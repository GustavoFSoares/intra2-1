<template>
    <div>
        <blockquote class="blockquote signature">
            <footer class="blockquote-footer">
                <span v-if="label">{{ label }}: </span>
                <cite title="Source Title"><b> {{ username }} </b></cite>
            </footer>
        </blockquote>
    </div>
</template>

<script>
export default {
    props: {
        label: { default: "" },
        username: { default: "" },
    }
    
}
</script>

<style scoped>
    .signature {
        text-align: right;
        margin-right: 20px;
    }
</style>
