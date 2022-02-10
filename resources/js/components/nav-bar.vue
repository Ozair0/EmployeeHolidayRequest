<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/"> Laravel </a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto"></ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    <li v-if="!isLoggedIn" class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                    <li v-if="!isLoggedIn" class="nav-item">
                        <a class="nav-link" href="/register">Register</a>
                    </li>
                    <li v-if="isAdmin" class="nav-item">
                        <a class="nav-link" href="/admin">Admin</a>
                    </li>
                    <li v-if="isLoggedIn" class="nav-item dropdown">
                        <a @click.prevent="logout()" class="nav-link" href="#">
                            logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    data() {
        return {
            isLoggedIn: false,
            isAdmin: false,
        };
    },
    created() {
        this.isLoggedIn =
            localStorage.getItem("token") === "" ||
            localStorage.getItem("token") === undefined ||
            localStorage.getItem("token") === "null"
                ? false
                : true;
    },
    mounted() {
        axios
            .post("/api/profile", {},{
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("token")}`,
                },
            })
            .then((res) => {
                if (res.data.type.trim() == "mang") this.isAdmin = true;
                localStorage.setItem("type", "mang")
            });
    },
    methods: {
        logout() {
            axios.post(
                "/api/logout",
                {
                    token: localStorage.getItem("token"),
                },
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                }
            );
            localStorage.setItem("token", null);
            localStorage.setItem("type", null)
            window.location.href = "/login";
        },
    },
};
</script>
