<template>
    <div class="task-list">
        <h1>Task List</h1>

        <div class="alert alert-danger" v-if="error !== false">Error: {{ error }}</div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th><span class="sr-only">Action</span></th>
                </tr>
            </thead>
            <tbody v-if="hasTasks">
                <tr v-for="task in tasks" v-bind:key="task.id">
                    <td>{{ task.id }}</td>
                    <td>{{ task.name }}</td>
                    <td><button class="btn btn-primary" v-on:click="remove(task.id)">Delete</button></td>
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
                error: false, 
                csrf: document.head.querySelector("[name~=csrf-token][content]").content
            }
        }, 
        methods: {
            load() {
                // Clear any previous errors 
                this.error = false;

                // Clear any previous tasks
                this.tasks = [];

                // Create the request
                fetch('task/read')
                    .then((response) => {
                        // Make sure there isn't a non-200 status
                        if (response.status !== 200) {
                            // Provide an error message
                            this.error = 'The server encountered an error while processing your request.';
                            // Don't continue
                            return false;
                        }

                        // Otherwise return the JSON response
                        return response.json();
                    })
                    .then((data) => {
                        // Check if tasks were returned
                        if (data.length > 0) {
                            // Let the component know there are tasks
                            this.hasTasks = true;
                            // Store the tasks
                            this.tasks = data;
                            return;
                        }

                        // Otherwise let the component know there are no tasks
                        this.hasTasks = false;
                    });
            }, 
            remove(id) {
                // Clear any previous errors 
                this.error = false;

                // Create the request
                fetch('task/delete', {
                        method: 'POST', 
                        headers: {
                            'Accept': 'application/json', 
                            'Content-Type': 'application/json'
                        }, 
                        body: JSON.stringify({ _token: this.csrf, id: id })
                    })
                    .then((response) => {
                        // Make sure there isn't a non-200 status
                        if (response.status !== 200) {
                            // Provide an error message
                            this.error = 'The server encountered an error while processing your request.';
                            // Don't continue
                            return;
                        }

                        // Reload the Task List
                        this.load();
                    });
            }
        }, 
        mounted() {
            // Load the Task List data
            this.load();
        }
    }
</script>
