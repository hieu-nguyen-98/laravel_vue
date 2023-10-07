<script setup>
    import axios from 'axios';
    import { ref , defineProps } from 'vue';
    import Swal from 'sweetalert2';

    const props = defineProps({
        user: Object,
        index: Number,
        selectAll: Boolean,
    });

    const emit = defineEmits(['userDeleted', 'editUser', 'ConfirmDeleteUser']);
    const toggleSelection = () => {
        emit('toggleSelection', props.user);
    }
    const roles = ref([
        {
            name: 'SUPPER_ADMIN',
            value: 1
        },
        {
            name: 'ADMIN',
            value: 2
        },
        {
            name: 'MANAGER',
            value: 3
        },
        {
            name: 'USER',
            value: 4,
        }
    ]);

    const changeRole = (user, role) => {
        axios.patch(`/api/users/${user.id}/change-role`, {
            role: role,
        })
        .then(() => {
            Swal.fire('success', 'Role changed successfully!', 'success');
            // toastr.success('Role changed successfully!');
        })
    };
    const formattedDate = (date) => {
        if (!date) return '';
        const dateTime = new Date(date);
        return dateTime.toLocaleDateString('en-US', { year: 'numeric', month: '2-digit', day: '2-digit' });
    }
</script>
<template>
    <tr> 
        <td><input type="checkbox" :checked="selectAll" @change="toggleSelection"/></td>
        <td>{{ index + 1 }}</td>
        <td>{{ user.name }}</td>
        <td> {{ user.email }} </td>
        <td> {{ formattedDate(user.created_at) }} </td>
        <td>
            <select class="form-control" @change="changeRole(user, $event.target.value)">
                <option v-for="role in roles" :value="role.value" :selected="(user.role === role.value)">{{ role.name }}</option>
            </select>
        </td>
        <td>
            <a class="edit__option" @click.prevent="$emit('editUser', user)"><i class="fa fa-edit"></i></a>
            <a class="edit__option" @click.prevent="$emit('ConfirmDeleteUser', user.id)"><i class="fa fa-trash text-danger ml-2"></i></a>
        </td>
    </tr>
</template>
<style scoped>
.edit__option{
    cursor: pointer;
}
</style>