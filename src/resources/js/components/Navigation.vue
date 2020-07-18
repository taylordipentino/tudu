<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <router-link class="navbar-brand" to="/">Tudu</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/">Dashboard</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/add-task">Add Task</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/about">About</router-link>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <button class="nav-link btn btn-link" v-on:click="logout">Logout</button>
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
                token: document.head.querySelector("[name~=csrf-token][content]").content
            }
        }, 
        methods: {
            logout() {
                // Create the request
                fetch('logout', {
                        headers: {
                            'Accept': 'application/json', 
                            'Content-Type': 'application/json'
                        }, 
                        method: 'POST', 
                        body: JSON.stringify({ _token: this.token })
                    })
                    .then((response) => {
                        // Reload
                        location.reload();
                    });
            }
        }
    }
</script>
