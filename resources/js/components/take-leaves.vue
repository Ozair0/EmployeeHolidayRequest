<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Take Leave</div>
                    <div class="card-body">
                        <form method="POST" action="test">
                            <div class="row mb-3">
                                <label
                                    for="password"
                                    class="col-md-4 col-form-label text-md-end"
                                    >Reason</label
                                >

                                <div class="col-md-6">
                                    <input
                                        v-model="reason"
                                        type="text"
                                        class="form-control"
                                        name="reason"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label
                                    for="password"
                                    class="col-md-4 col-form-label text-md-end"
                                    >From</label
                                >

                                <div class="col-md-6">
                                    <input
                                        v-model="from"
                                        type="date"
                                        class="form-control"
                                        name="from"
                                        required
                                        :min="minDate"
                                    />
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label
                                    for="password"
                                    class="col-md-4 col-form-label text-md-end"
                                    >To</label
                                >

                                <div class="col-md-6">
                                    <input
                                        v-model="to"
                                        type="date"
                                        class="form-control"
                                        name="to"
                                        required
                                        :min="minDate"
                                    />
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        @click.prevent="submit()"
                                    >
                                        Submit
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
    data() {
        return {
            from: "",
            to: "",
            reason: "",
            minDate: ""
        };
    },
    created() {
        if (
            localStorage.getItem("token") === "" ||
            localStorage.getItem("token") === undefined ||
            localStorage.getItem("token") === "null"
        ) {
            window.location.href = "/login";
        }
        const dateObj = new Date();
        const currentDate =
            dateObj.getFullYear() +
            "-" +
            (dateObj.getMonth() + 1 <= 9
                ? "0" + (dateObj.getMonth() + 1)
                : dateObj.getMonth() + 1) +
            "-" +
            dateObj.getDate();
        this.minDate = currentDate;
    },
    methods: {
        submit() {
            axios
                .post(
                    "/api/leave/store",
                    {
                        reason: this.reason.trim(),
                        from: this.from.trim(),
                        to: this.to.trim(),
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "token"
                            )}`,
                        },
                    }
                )
                .then((res) => {
                    window.location.href = "/";
                }).catch(e => {
                    alert(e.response.data.masg);
                });
        },
    },
};
</script>
