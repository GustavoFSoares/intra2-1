<template>
    <div class="container-fluid">
        <h1>{{ title }}</h1>
        
        <list/>
    </div>
</template>

<script>
import List from '@/components/shared/List.vue'
export default {

    data() {
        return {
            title: "Links Úteis",
            user: $session.get('user'),
        }
    },
    components: {
        'list': List,
    },
    mounted() { },

}
</script>