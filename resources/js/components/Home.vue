<template>
</template>
<script>
export default {
    name: "Home",
    data(){
        return {
        }
    },
    mounted(){
        this.$router.push({ name: "dashboard"})
    }
}
</script>