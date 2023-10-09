<script setup>

    import { onMounted, ref } from 'vue';
    import Swal from 'sweetalert2';
    
    const settings = ref([]);
    const getSettings = () => {
        axios.get('/api/settings')
        .then((resp) => {
            settings.value = resp.data;
        });
    };  

    const errors = ref();
    const updateSettings = () => {
        errors.value = '';
        axios.post(`/api/settings/${settings.value.id}`, settings.value)
        .then((response) => {
            Swal.fire(
                'success!',
                'Your file has been updated!',
                'success'
            )
        })
        .catch((error) => {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors;
            }
        });
    };


    onMounted(() => {
        getSettings();
    });
</script>
<template>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1 class="m-0">Settings</h1> -->
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9 m-auto">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">General Setting</h3>
                        </div>
                        <form @submit.prevent="updateSettings()">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="appName">App Display Name</label>
                                    <input v-model="settings.name_app" type="text" class="form-control" id="appName"
                                        placeholder="Enter app display name">
                                    <span class="text-danger text-sm" v-if="errors && errors.app_name">{{ errors.app_name[0] }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="appName">Logo</label>
                                    <input v-model="settings.logo" type="text" class="form-control" id="appName"
                                        placeholder="Enter app display name">
                                    <span class="text-danger text-sm" v-if="errors && errors.app_name">{{ errors.app_name[0] }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="appName">Email</label>
                                    <input v-model="settings.email" type="text" class="form-control" id="appName"
                                        placeholder="Enter app display name">
                                    <span class="text-danger text-sm" v-if="errors && errors.app_name">{{ errors.app_name[0] }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="appName">Address</label>
                                    <input v-model="settings.address" type="text" class="form-control" id="appName"
                                        placeholder="Enter app display name">
                                    <span class="text-danger text-sm" v-if="errors && errors.app_name">{{ errors.app_name[0] }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="appName">Phone 1</label>
                                    <input v-model="settings.phone_1" type="text" class="form-control" id="appName"
                                        placeholder="Enter app display name">
                                    <span class="text-danger text-sm" v-if="errors && errors.app_name">{{ errors.app_name[0] }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="appName">Phone 2</label>
                                    <input v-model="settings.phone_2" type="text" class="form-control" id="appName"
                                        placeholder="Enter app display name">
                                    <span class="text-danger text-sm" v-if="errors && errors.app_name">{{ errors.app_name[0] }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="appName">Facebook url</label>
                                    <input v-model="settings.facebook" type="text" class="form-control" id="appName"
                                        placeholder="Enter app display name">
                                    <span class="text-danger text-sm" v-if="errors && errors.app_name">{{ errors.app_name[0] }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="appName">Instagram url</label>
                                    <input v-model="settings.instagram" type="text" class="form-control" id="appName"
                                        placeholder="Enter app display name">
                                    <span class="text-danger text-sm" v-if="errors && errors.app_name">{{ errors.app_name[0] }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="appName">Youtube url</label>
                                    <input v-model="settings.youtube" type="text" class="form-control" id="appName"
                                        placeholder="Enter app display name">
                                    <span class="text-danger text-sm" v-if="errors && errors.app_name">{{ errors.app_name[0] }}</span>
                                </div>
                                <div class="form-group">
                                    <label for="appName">Linked url</label>
                                    <input v-model="settings.linked" type="text" class="form-control" id="appName"
                                        placeholder="Enter app display name">
                                    <span class="text-danger text-sm" v-if="errors && errors.app_name">{{ errors.app_name[0] }}</span>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-save mr-1"></i>Save
                                    Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>