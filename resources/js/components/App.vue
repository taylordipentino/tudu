<template>
    <div>
        <h1>My App</h1>
        
        <router-link to="/">Home</router-link>
        <router-link to="/add-task">Add Task</router-link>

        <router-view></router-view>
    </div>
</template>

<script>
    export default {};
</script>
