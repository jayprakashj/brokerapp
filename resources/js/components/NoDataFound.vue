<template>
    <div
        class=" col-span-12 text-center bg-white rounded-lg  px-4 py-4 text-black sm:px-5"
        >
        {{ message }}
    </div>

</template>

<script>
export default {
    props:{
        message: {
            type: String,
            default: 'No information available.'
        }
    }
}
</script>

<style>

</style>
