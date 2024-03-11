<script>
//Использовать расширение .vue
import Layout from '../Shared/Layout.vue';
import {Head} from '@inertiajs/vue3'
    export default {
        components:{
            Head
        },
        props:{
            title:String,

        },
        layout:Layout
    }
</script>

<template>
    <Head>
        <title>
            {{ title }}
        </title>
    </Head>
    <h1>{{ title }}</h1>
</template>


