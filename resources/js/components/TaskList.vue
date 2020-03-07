<template>
    <div class="task-list">
        <h1>Task List</h1>

        <div class="alert alert-danger" v-if="error !== false">Error: {{ error }}</div>

        <table>
            <thead>
                <tr>
                    <th><span class="sr-only">Task Name</span></th>
                    <th><span class="sr-only">Task Action</span></th>
                </tr>
            </thead>
            <tbody v-if="hasTasks">
                <tr v-for="task in tasks" v-bind:key="task.id" class="task">
                    <td>
                        <span class="task-name">{{ task.name }}</span>
                    </td>
                    <td>
                        <button class="delete-task text-primary" title="Delete Task" v-on:click="remove(task.id)">
                            <span class="sr-only">Delete Task</span>
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="trash" class="svg-inline--fa fa-trash fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"></path></svg>
                        </button>
                    </td>
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

<style scoped>
    table, thead, tbody, tr {
        display: block;
    }

    th, td {
        display: inline-block;
        box-sizing: border-box;
        font-size: 1.2rem;
        vertical-align: bottom;
    }

    th:first-child, 
    td:first-child {
        width: calc(90% - 2px);
    }

    th:last-child, 
    td:last-child {
        width: calc(10% - 2px);
        text-align: right;
    }

    .task {
        border: 1px solid #e0e0e0;
        border-radius: 0.5em;
        padding: 1em;
        background-color: #fff;
        margin-bottom: 1em;
    }

    .task-name {
        display: block;
        margin-bottom: -2px;
    }

    .delete-task svg {
        height: 1.2rem;
    }

    .delete-task {
        background: none;
        border: none;
    }
</style>
