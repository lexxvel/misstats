<template>
  <option v-bind:value=this.id >{{Option}}</option>
</template>

<script>
export default {
    props: {
        Option: {
            type: String,
            default: ""
        },
        id: {
           type: Number,
            default: undefined
        }
    }
}
</script>

<style>

</style>
