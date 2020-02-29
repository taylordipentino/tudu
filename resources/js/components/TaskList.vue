<template>
    <div class="task-list">
        <h1>Task List</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody v-if="hasTasks">
                <tr v-for="task in tasks" v-bind:key="task.id">
                    <td>{{ task.id }}</td>
                    <td>{{ task.name }}</td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr><td colspan="2">There are no Tasks available at this time.</td></tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                tasks: [], 
                hasTasks: false, 
                csrf: document.head.querySelector("[name~=csrf-token][content]").content
            }
        }, 
        mounted() {
            fetch('task/read')
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    if (data.length > 0) {
                        this.hasTasks = true;
                        this.tasks = data;
                        return;
                    }

                    this.hasTasks = false;
                });
        }
    }
</script>
