<template>
    <div class="app">
        <navigation></navigation>        
        <div class="py-4">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
    import Navigation from '@/js/components/Navigation';

    export default {
        components: {
            Navigation
        }
    }
</script>
