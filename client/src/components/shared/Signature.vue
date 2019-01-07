<template>
    <blockquote class="blockquote pull-right signature">
        <footer class="blockquote-footer">{{ label }}: 
            <cite title="Source Title"><b> {{ username }} </b></cite>
        </footer>
    </blockquote>
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
