<template>
    <div v-if="document">
        <row>
            <h4>
                <span class="bold"> Protocolo: </span> {{ document.id }}
            </h4>
        </row>

        <box class="border-secondary" v-if="document.content">
            <row>
                <h1>{{ document.subject }}</h1>
            </row>

            <hr>
            <row>
                <div id="content">
                    <p>Prezados: </p>
                    
                    <div>
                        <div v-html="document.content"></div>
                    </div>
                </div>
                <signature :username="`${document.user.name} - ${document.user.code}`"/>
                <p class="date">{{ document.createdAt | humanizeDate }}</p> 
            </row>
            <row class="amendment-list">
                <div class="amendment mt-3" v-for="(amendment, index) in document.amendmentList" :key="index">
                    <div class="bold">§<span class="ml-3">{{ index+1 }} - {{ amendment.title }}</span> </div>
                    <div>
                        <div v-html="amendment.text"></div>
                    </div>
                    <signature :username="`${amendment.user.name} - ${amendment.user.code}`"/>
                </div>
            </row>
        </box>
    </div>
</template>

<script>
import Signature from "@/components/shared/Signature";

export default {
    props: {
        document: ''
    },
    components: {
        'signature': Signature,
    }
}
</script>

<style lang="scss" scoped>
    .date {
        text-align: right;
        margin-right: 20px;
        margin-top: -15px;
    }

    .amendment-list {
        margin-left: 15px
    }

    .amendment:hover {
        background-color: #dee2e6;
        border-radius: 5px;
    }
</style>
