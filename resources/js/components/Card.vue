<template>
    <card class="exact-online-svg-card" v-bind:class="{ 'bg-success': isActive, 'bg-danger': hasError }">
        <svg class="exact-online-svg-card-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40"><path fill="#E1141D" d="M26.6,26.1h-8c-3.8,0-5.6-1.4-6.1-4.8h11.8v0h4.1v-1.2c0,0,0-0.1,0-0.1v-4.1c0,0,0-0.1,0-0.1v-1.2h-1.2
            c0,0-0.1,0-0.1,0H12.5c0.5-3.5,2.2-5,6.1-5h12V2.8h-3.6v0h-9.2C8.5,2.8,5,7.5,5,17.8c0,10.3,3.6,15,12.9,15h11.6c0,0,0,0,0,0h1.3
            v-6.8C30.8,26.1,26.6,26.1,26.6,26.1z"/></svg>
        <div class="flex flex-col items-center justify-center">
            <div v-if="card_status === 'checking'" class="px-3 py-3 mt-6">
                <!-- <h1 class="text-center text-3xl text-80 font-light">{{ text }}</h1> -->
                <svg
                    class="spin fill-80 mb-6"
                    width="69"
                    height="72"
                    viewBox="0 0 23 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M20.12 20.455A12.184 12.184 0 0 1 11.5 24a12.18 12.18 0 0 1-9.333-4.319c4.772 3.933 11.88 3.687 16.36-.738a7.571 7.571 0 0 0 0-10.8c-3.018-2.982-7.912-2.982-10.931 0a3.245 3.245 0 0 0 0 4.628 3.342 3.342 0 0 0 4.685 0 1.114 1.114 0 0 1 1.561 0 1.082 1.082 0 0 1 0 1.543 5.57 5.57 0 0 1-7.808 0 5.408 5.408 0 0 1 0-7.714c3.881-3.834 10.174-3.834 14.055 0a9.734 9.734 0 0 1 .03 13.855zM4.472 5.057a7.571 7.571 0 0 0 0 10.8c3.018 2.982 7.912 2.982 10.931 0a3.245 3.245 0 0 0 0-4.628 3.342 3.342 0 0 0-4.685 0 1.114 1.114 0 0 1-1.561 0 1.082 1.082 0 0 1 0-1.543 5.57 5.57 0 0 1 7.808 0 5.408 5.408 0 0 1 0 7.714c-3.881 3.834-10.174 3.834-14.055 0a9.734 9.734 0 0 1-.015-13.87C5.096 1.35 8.138 0 11.5 0c3.75 0 7.105 1.68 9.333 4.319C16.06.386 8.953.632 4.473 5.057z"
                        fill-rule="evenodd"
                    />
                </svg>
            </div>
            <div v-if="card_status === 'loaded'" class="px-3 py-3">
                <h1 class="text-center text-white-50% mt-6">{{ header }}</h1>
                <p class="text-white-50% text-center">
                    {{ text }}<br/>
                    <a v-if="hasError === true" class="btn  mt-2" href="/nova/exact-online">
                        Koppel nu
                    </a>
                </p>
            </div>
        </div>
    </card>
</template>

<script>
export default {
    props: [
        'card',

        // The following props are only available on resource detail cards...
        // 'resource',
        // 'resourceId',
        // 'resourceName',
    ],

    data () {
        return {
            header: 'Checking connection',
            text: '',
            card_status: 'checking',
            hasError: false,
            isActive: false
        }
    },

    mounted() {
        let vue = this;
        Nova.request().get('/nova-vendor/exact-online/connected')
            .then(response => {
                if (response.data.connected) {
                    this.card_status = 'loaded'
                    this.header = 'Verbonden'
                    this.text = 'Verbinding met Exact Online is goed'
                    this.isActive = true
                    this.hasError = false
                } else {
                    this.card_status = 'loaded'
                    this.header = 'Niet verbonden'
                    this.text = 'Er is geen verbinding met Exact Online'
                    this.isActive = false
                    this.hasError = true
                }
                
            }).catch(response => {
                
            });
    }
}
</script>
<style>
    .exact-online-svg-card {
        position: relative;
    }
    .exact-online-svg-card-icon {
        position: absolute;
        left: 10px;
        top: 10px;
        width: 20px
    }
</style>