<template>
    <div
        class="alert flex rounded-lg border border-error px-4 py-4 text-error sm:px-5"
        >
        {{ message }}
    </div>

</template>

<script>
export default {
    props:{
        message: {
            type: String,
            default: 'No data found!'
        }
    }
}
</script>

<style>

</style>
