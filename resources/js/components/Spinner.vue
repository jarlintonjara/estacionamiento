<template>
    <div class="loader-container">
        <div class="spinner-border" role="status" style="width: 7rem; height: 7rem; border-width: 0.5rem; color: #425777">
        <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
            }
        }
    }
</script>

<style>
    main {
        position: relative;
    }
    .loader-container{
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        right: 0;
        z-index: 1;
    }
</style>