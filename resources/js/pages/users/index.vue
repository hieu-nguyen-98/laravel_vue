<script setup>
    import axios from 'axios';
    import { ref, onMounted, reactive, watch } from 'vue';
    import * as yup from 'yup';
    import { Form, Field, useResetForm, useSetFieldError } from 'vee-validate';
    import Swal from 'sweetalert2';
    import ListData from './listData.vue';
    import { debounce } from 'lodash';
    import  {Bootstrap4Pagination } from 'laravel-vue-pagination';

    const users = ref({'data': []});
    const formValues = ref();
    const edit = ref(false);
    const form = ref(null);
    const searchQuery = ref(null);

    const startIndex = ref(0);
    const pageSize = 10;
    const getUsers = (page = 1) => {
        axios.get(`/api/users?page=${page}`, {
            params: {
                query: searchQuery.value
            }
        })
        .then((resp) => {
            users.value = resp.data;
            startIndex.value = (page - 1) * pageSize;
            selectedUsers.value = [];
            selectAll.value = false;
        });
    }

    // const search = () => {
    //     axios.get('/api/users/search', {
    //         params: {
    //             query: searchQuery.value
    //         }
    //     })
    //     .then((resp) => {
    //         users.value.data = resp.data;
    //     })
    //     .catch(error => {
    //         console.log(error)
    //     })
    // }

    const addUser = () => {
        edit.value = false;
        $('#userFormModal').modal('show');
    }

    const createUser = (value, {resetForm, setErrors}) => {
        axios.post('/api/users', value)
        .then((resp) => {
            users.value.data.unshift(resp.data)
            $('#userFormModal').modal('hide');
            Swal.fire('success', 'Add new user successfully!', 'success'); // You can customize the alert type (info, success, warning, error) here
            resetForm();
        })
        .catch((error) => {
            if (error.response.data.errors) {
                setErrors(error.response.data.errors); //Validate Api
            }
        });
    }

    const createUserSchema = yup.object({ //Validate vue
        name: yup.string().required(),
        email: yup.string().email().required(),
        password: yup.string().required().min(8),
    });

    const editUserSchema = yup.object({ //Validate vue
        name: yup.string().required(),
        email: yup.string().email(),
        // password: yup.string().when((password, schema) => {
        //     return password ? schema.required().min(8) : schema;
        // }),
    });

    const editUser = (user) => {
        console.log(user)
        edit.value = true;
        form.value.resetForm();
        $('#userFormModal').modal('show');
        formValues.value = {
            id : user.id,
            name : user.name,
            email : user.email,
            password : user.password,
        };
    }

    const updateUser = (val, {setErrors}) => {
        axios.put('/api/users/' + formValues.value.id, val)
        .then((resp) => {
            const index = users.value.data.findIndex(user => user.id == resp.data.id)
            users.value.data[index] = resp.data;
            console.log(users)
            $('#userFormModal').modal('hide')
            Swal.fire('success', 'Update user successfully!', 'success'); // You can customize the alert type (info, success, warning, error) here
        }).catch((error) => {
            setErrors(error.response.data.errors); //Validate Api
        })
    }

    const handleSubmit = (values, actions) => {
        if (edit.value) {
            updateUser(values, actions);
        } else {
            createUser(values, actions);
        }
    }

    const userIdDeleted = ref(null);
    const ConfirmDeleteUser = (id) =>{
        userIdDeleted.value = id
        $('#deleteUserModal').modal('show')
    }

    const deleteUser = () => {
        axios.delete(`/api/users/${userIdDeleted.value}`)
        .then(() => {
            $('#deleteUserModal').modal('hide');
            Swal.fire('success', 'Delete user successfully!', 'success'); // You can customize the alert type (info, success, warning, error) here
            users.value = users.value.filter(user => user.id !== userIdDeleted.value);
        });
    };

    const selectedUsers = ref([]);
    const toggleSelection = (user) => {
        const index = selectedUsers.value.indexOf(user.id);
        if (index === -1) {
            selectedUsers.value.push(user.id);
        } else {
            selectedUsers.value.splice(index, 1);
        }
        console.log(selectedUsers.value);
    };

    const selectAll = ref(false);
    const selectAllUsers = () => {
        if (selectAll.value) {
            selectedUsers.value = users.value.data.map(user => user.id);
        } else {
            selectedUsers.value = [];
        }
        console.log(selectedUsers.value);
    }

    const multpDelete = () => {
        axios.delete('/api/users', {
            data: {
                ids: selectedUsers.value
            }
        })
        .then(resp => {
            users.value.data = users.value.data.filter(user => !selectedUsers.value.includes(user.id));
            selectedUsers.value = [];
            selectAll.value = false;
            Swal.fire('success', resp.data.message, 'success');
        });
    };

    watch(searchQuery, debounce(() => {
        getUsers();
    }, 300));
    onMounted(() => {
        getUsers();
    });

</script>
<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <div class="d-flex">
                    <button @click="addUser" type="button" class="mb-2 btn btn-primary">
                        <i class="fa fa-plus-circle changeRolemr-1"></i>
                        Add New User
                    </button>
                    <div v-if="selectedUsers.length > 0">
                        <button @click="multpDelete" type="button" class="ml-2 mb-2 btn btn-danger">
                            <i class="fa fa-trash mr-1"></i>
                            Delete
                        </button>
                        <span class="ml-2">Selected <span class="text-danger">{{ selectedUsers.length }}</span> users</span>
                    </div>
                </div>
                <div>
                    <input type="text" v-model="searchQuery" class="form-control" placeholder="Search..." />
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <th><input type="checkbox" v-model="selectAll" @change="selectAllUsers" /></th>
                            <th>STT</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Register Date</th>
                            <th>Role</th>
                            <th>Option</th>
                        </thead>
                        <tbody v-if="users.data.length > 0">
                            <list-data v-for="(user, index) in users.data"
                                :key="user.id"
                                :user="user" 
                                :index="startIndex + index"
                                @edit-user="editUser"
                                @confirm-delete-user="ConfirmDeleteUser"
                                @toggle-selection="toggleSelection"
                                :select-all="selectAll"
                            ></list-data>
                        </tbody>
                        <tbody v-else>
                            <td colspan="6" class="text-center">No results found...</td>
                        </tbody>
                    </table>
                </div>
            </div>
            <Bootstrap4Pagination :data="users" @pagination-change-page="getUsers" class="float-right"/>
        </div>
    </div>

    <!--Start Modal -->
    <div class="modal fade" id="userFormModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span v-if="edit">Edit User</span>
                        <span v-else>Add New User</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <Form ref="form" @submit="handleSubmit" :validation-schema="edit ? editUserSchema : createUserSchema" v-slot="{ errors }" :initial-values="formValues">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <Field name="name" type="text" class="form-control" :class="{'is-invalid' : errors.name}"
                                id="name" placeholder="Enter full name" />
                            <span class="invalid-feedback"> {{ errors.name }} </span>
                        </div>
    
                        <div class="form-group">
                            <label for="email">Email</label>
                            <Field name="email" type="email" class="form-control" :class="{'is-invalid' : errors.email}"
                                id="email" placeholder="Enter email name" />
                            <span class="invalid-feedback"> {{ errors.email }} </span>
                        </div>
    
                        <div class="form-group">
                            <label for="password">Password</label>
                            <Field name="password" type="password" class="form-control" :class="{'is-invalid' : errors.password}"
                                    id="password" placeholder="Enter password" />
                            <span class="invalid-feedback"> {{ errors.password }} </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </Form>
            </div>
        </div>
    </div>
    <!--End Modal -->

    <!--Start Delete Modal -->
    <div class="modal fade" id="deleteUserModal" data-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span>Delete User</span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Are you sure you want to delete this user ?</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button @click.prevent="deleteUser" type="button" class="btn btn-primary">Delete User</button>
                </div>
            </div>
        </div>
    </div>
    <!--End Delete Modal -->

</template>
