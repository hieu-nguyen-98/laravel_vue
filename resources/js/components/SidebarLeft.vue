<script setup>
    import { useRouter } from 'vue-router';
    import { ref, onMounted, computed } from 'vue';

    const user = ref({
        id : '',
        name: '',
        email: '',
        role: '',
        avatar: '',
    });
    const getAuthUser = () => {
        return new Promise((resolve, reject) => {
            axios.get('/api/profile')
                .then((response) => {
                    user.value = response.data;
                    resolve(user.value); // Trả về dữ liệu sau khi đã lấy từ máy chủ
                })
                .catch((error) => {
                    reject(error);
                });
        });
    };
    
    const router = useRouter();

    const logout = () => {
        axios.get('/admin/logout')
        .then((response) => {
            if(response.data.success){ 
                user.name = '';
                window.location.href = '/admin/login'; 
            }
        });
    };

    onMounted(() => {
        getAuthUser()
        .then((user) => {
        })
        .catch((error) => {
            console.error(error);
        });
    })
</script>

<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <router-link to="/admin/dashboard" class="brand-link">
            <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Trang Quản Trị</span>
        </router-link>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img :src="user.avatar ? user.avatar : '/noimage.png'"
                        class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ user.name }}</a>
                </div>
            </div>

            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <router-link to="/admin/dashboard" active-class="active" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                                <span class="right badge badge-danger">New</span>
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/admin/appointments" class="nav-link" :class="$route.path.startsWith('/admin/appointments') ? 'active' : ''">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>
                                Appointments
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/admin/users" active-class="active" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Users
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/admin/settings" active-class="active" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Settings
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/admin/profiles"  active-class="active" class="nav-link">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Profiles
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item ml-3">
                        <a @click.prevent="logout" href="">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <span>
                                Logout
                            </span>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
    </aside>
</template>