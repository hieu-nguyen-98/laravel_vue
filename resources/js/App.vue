<script setup>
    import { ref, onMounted, computed } from 'vue';
    import AppNavbar from './components/AppNavbar.vue';
    import SidebarLeft from './components/SidebarLeft.vue';
    import SidebarRight from './components/SidebarRight.vue';
    import AppFooter from './components/AppFooter.vue';
// import { useSettingStore } from './stores/SettingStore';

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
    onMounted(() => {
        getAuthUser()
        .then((user) => {
            console.log(user.id); // Dữ liệu sẽ được hiển thị ngay cả khi ở bên ngoài hàm then
        })
        .catch((error) => {
            console.error(error);
        });
    })
// const currentThemeMode = computed(() => {
//     return settingStore.theme === 'dark' ? 'dark-mode' : '';
// });
</script>

<template>
    <div id="app" v-if="user.name != ''">
        <AppNavbar />
        <SidebarLeft />
        <div class="content-wrapper">
            <router-view></router-view>
        </div>
        <SidebarRight />
        <AppFooter />
    </div>
    <div v-else class="login-page">
        <router-view></router-view>
    </div>
</template>