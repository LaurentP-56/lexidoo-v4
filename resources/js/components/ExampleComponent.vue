<script>
export default {
    data() {
        return {
            message: 'Hello Vue 3!',
            count: 0
        }
    }
}
</script>

<template>
    <div>
        <h1>{{ message }}</h1>
        <button @click="count++">Vous avez cliqué {{ count }} fois.</button>
    </div>
</template>

<style scoped>
/* Vos styles ici */
</style>
