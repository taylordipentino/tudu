<template>
    <div class="add-task container">
        <h1>Add Task</h1>

        <div class="alert alert-danger" v-if="error !== false">Error: {{ error }}</div>

        <div class="form-group row">
            <div class="col-sm-10">
                <input class="form-control" type="text" placeholder="What are we going to accomplish today?" v-model="name">
            </div>
            <div class="col-sm-2">
                <button class="btn btn-primary" type="submit" v-on:click="submit">Create Task</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: '', 
                error: false, 
                token: document.head.querySelector("[name~=csrf-token][content]").content
            }
        }, 
        methods: {
            submit() {
                // Clear any previous errors 
                this.error = false;

                // Make sure the task name isn't blank
                if (this.name == '') {
                    // Provide an error message
                    this.error = 'The task name cannot be blank.';
                    // Don't continue
                    return;
                }

                // Create the request
                fetch('task/create', {
                        headers: {
                            'Accept': 'application/json', 
                            'Content-Type': 'application/json'
                        }, 
                        method: 'POST', 
                        body: JSON.stringify({ _token: this.token, name: this.name })
                    })
                    .then((response) => {
                        // Make sure there isn't a non-200 status
                        if (response.status !== 200) {
                            // Provide an error message
                            this.error = 'The server encountered an error while processing your request.';
                            // Don't continue
                            return;
                        }

                        // Redirect to the dashboard
                        this.$router.push('/');
                    });
            }
        }
    }
</script>

