<template>
    <div class="add-task container">
        <h1>Add Task</h1>

        <div class="alert alert-danger" v-if="error !== false">Error: {{ error }}</div>

        <div class="input mt-4">
            <div class="text">
                <input type="text" placeholder="What are we going to accomplish today?" v-model="name">
            </div>
            <div class="button">
                <button class="create-task text-primary" title="Create Task" v-on:click="submit">
                    <span class="sr-only">Create Task</span>
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="arrow-alt-circle-right" class="svg-inline--fa fa-arrow-alt-circle-right fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8c137 0 248 111 248 248S393 504 256 504 8 393 8 256 119 8 256 8zM140 300h116v70.9c0 10.7 13 16.1 20.5 8.5l114.3-114.9c4.7-4.7 4.7-12.2 0-16.9l-114.3-115c-7.6-7.6-20.5-2.2-20.5 8.5V212H140c-6.6 0-12 5.4-12 12v64c0 6.6 5.4 12 12 12z"></path></svg>
                </button>
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

<style scoped>
    .input {
        display: block;
        border: 1px solid #e0e0e0;
        border-radius: 0.5em;
        padding: 1em;
        background-color: #fff;
        margin-bottom: 1em;
    }

    .input .text, 
    .input .button {
        display: inline-block;
        box-sizing: border-box;
        font-size: 1.2rem;
        vertical-align: bottom;
    }

    .input .text {
        width: calc(90% - 2px);
    }

    .input .text input {
        border: 0;
        display: block;
        width: 100%;
        margin-bottom: -2px;
    }

    .input .button {
        width: calc(10% - 2px);
        text-align: right;
    }

    button.create-task {
        background: none;
        border: none;
    }

    .input .button svg {
        height: 1.5rem;
    }
</style>
