<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login Page</div>
                    <div class="card-body">
                        <form method="POST" action="test">
                            <div class="row mb-3">
                                <label
                                    for="email"
                                    class="col-md-4 col-form-label text-md-end"
                                    >Email</label
                                >
                                <div class="col-md-6">
                                    <input
                                        v-model="email"
                                        type="email"
                                        class="form-control"
                                        name="email"
                                        value="Email"
                                        required
                                        autocomplete="email"
                                        autofocus
                                    />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label
                                    for="password"
                                    class="col-md-4 col-form-label text-md-end"
                                    >Password</label
                                >

                                <div class="col-md-6">
                                    <input
                                        v-model="password"
                                        type="password"
                                        class="form-control"
                                        name="password"
                                        required
                                        autocomplete="current-password"
                                    />
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        @click.prevent="login()"
                                    >
                                        Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    // mounted() {
    //     // console.log(localStorage.getItem('books'))
    //     if (!(localStorage.getItem('token') == "" || localStorage.getItem('books') == undefined || localStorage.getItem('books') == null) ) {
    //         window.location.href = "/"
    //     }
    // },
    created() {
        if (
            !(
                localStorage.getItem("token") === '' ||
                localStorage.getItem("token") === undefined ||
                localStorage.getItem("token") === 'null'
            )
        ) {
            window.location.href = "/";
        }
    },
    data() {
        return {
            email: "",
            password: "",
        };
    },
    methods: {
        login() {
            axios
                .post("/api/login", {
                    email: this.email.trim(),
                    password: this.password.trim(),
                })
                .then((res) => {
                    localStorage.setItem("token", res.data.access_token);
                    window.location.href = "/";
                });
        },
    },
};
</script>
