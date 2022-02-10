<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header flex justify-content-between">
                        <p>Leaves</p>
                        <a
                            v-if="loggedIn"
                            href="/take_leave"
                            :class="`btn btn-primary${isAdmin ? ' disabled':''}`"
                        >
                            Take a leave
                        </a>
                    </div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Reason</th>
                                    <th scope="col">From</th>
                                    <th scope="col">To</th>
                                    <th scope="col">Statue</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(item, index) in leaves"
                                    :key="item.id"
                                >
                                    <th scope="row">{{ index + 1 }}</th>
                                    <td>{{ item.reason }}</td>
                                    <td>{{ item.from }}</td>
                                    <td>{{ item.to }}</td>
                                    <td>
                                        <button
                                            :class="`btn + ${
                                                item.is_approved
                                                    ? ' btn-info'
                                                    : ' btn-secondary'
                                            }`"
                                            disabled
                                        >
                                            {{
                                                item.is_approved
                                                    ? "Approved"
                                                    : "Pending"
                                            }}
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loggedIn: false,
            leaves: [],
            isAdmin: false,
        };
    },
    mounted() {
        axios
            .post(
                "/api/profile",
                {},
                {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            "token"
                        )}`,
                    },
                }
            )
            .then((res) => {
                if (res.data.type.trim() == "mang") this.isAdmin = true;
                localStorage.setItem("type", "mang");
            });
    },
    created() {
        this.loggedIn = !(
            localStorage.getItem("token") === "" ||
            localStorage.getItem("token") === undefined ||
            localStorage.getItem("token") === "null"
        );
        axios
            .get("/api/leave/get", {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("token")}`,
                },
            })
            .then((res) => {
                this.leaves = res.data;
            });
    },
};
</script>
