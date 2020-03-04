<template>
    <div class="home container">
        <task-list></task-list>
    </div>
</template>

<script>
    import TaskList from '@/js/components/TaskList';

    export default {
        components: {
            TaskList
        }
    }
</script>
