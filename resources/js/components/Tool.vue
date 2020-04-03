<template>
    <div>
        <heading class="mb-6">Exact Online</heading>
        <div v-if="app_status === 'connected'" class="relative">
            <card
                class="bg-success mb-6 flex flex-col items-center justify-center"
                style="min-height: 100px"
            >
                <p class="text-white-50% text-lg">
                    {{ text.connection_successfull }}
                </p>
            </card>
            <div class="card mb-6 py-3 px-6">
                <div v-for="field in this.visible_user_fields" class="flex border-b border-40">
                    <div class="w-1/4 py-4">
                        <h4 class="font-normal text-80">{{ field }}</h4>
                    </div> 
                    <div class="w-3/4 py-4 break-words">
                        <p class="text-90">
                            {{ user[field] }}
                        </p>
                    </div>
                </div>
            </div>
            <a href="#" v-on:click="disconnect" class="btn btn-default btn-danger">
                {{ text.disconnect_button_text }}
            </a>
        </div>

        <card
            v-if="app_status === 'show_auth'"
            class="bg-90 flex flex-col items-center justify-center"
            style="min-height: 300px"
        >
            <h1 class="text-white text-4xl text-90 font-light mb-6">
                {{ text.connect_to_exact }}
            </h1>

            <p class="text-white-50% text-lg">
                <a href="#" v-on:click="goToExactOnlineForAuth" class="btn btn-default btn-primary">
                    {{ text.connect_button_text }}
                </a>
            </p>
            <p v-if="error" class="text-white-50% text-lg mt-6">
                <code class="ml-1 border border-80 text-sm font-mono text-white bg-black rounded px-2 py-1">
                    {{ text.something_went_wrong }} "{{ error }}"
                </code>
            </p>
        </card>
        <card
            v-if="app_status === 'checking'"
            class="bg-90 flex flex-col items-center justify-center"
            style="min-height: 300px"
        >
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
            <h1 class="text-white text-4xl text-90 font-light mb-6">
                {{ text.loading.header }}
            </h1>

            <p class="text-white-50% text-lg">
                {{ text.loading.text }}
            </p>
        </card>
    </div>

</template>

<script>

export default {
    data () {
        return {
            text: {
                connect_button_text: 'Klik hier om te verbinden',
                disconnect_button_text: 'Klik hier om te verbinden te verbreken',
                connect_retry: 'Probeer het opnieuw',
                connection_successfull: 'Je hebt momenteel een actieve koppeling met Exact Online',
                connection_successfull_toaster: 'Yay, we hebben nu verbinding met Exact Online!',
                connect_to_exact: 'Maak een verbinding met je Exact Online',
                something_went_wrong: 'Er ging iets niet goed. We hebben de volgende fout ontvangen:',
                loading: {
                    header: 'Verbinding wordt gecontroleerd',
                    text: 'Een moment geduld. We zijn de verbinding aan het afronden en aan het controleren.'
                },
                disconnect: {
                    header: 'Verbinding wordt verbroken',
                    text: 'Een klein moment, we zijn de verbinding aan het verbreken',
                    success: 'Het is gelukt, je bent niet meer verbonden.'
                },
            },
            auth_url: null,
            error: null,
            user: null,
            visible_user_fields: [],
            app_status: 'checking'
        }
    },

    methods:{
        setAppStatus (status) {
            this.app_status = status
        },
        goToExactOnlineForAuth () {
            this.setAppStatus('checking')
            window.location.href = this.auth_url
        },
        disconnect () {
            this.setAppStatus('checking')
            let original_header = this.text.loading.header
            let original_text = this.text.loading.text

            this.text.loading.header = this.text.disconnect.header
            this.text.loading.text = this.text.disconnect.text
            Nova.request().get('/nova-vendor/exact-online/disconnect')
                .then(response => {
                    this.showConnectButton()
                    this.text.loading.header = original_header
                    this.text.loading.text = original_text
                    this.$toasted.show(this.text.disconnect.success, {type: "success"});

                }).catch(response => {
                    this.setAppStatus('connected')
                    this.text.loading.header = original_header
                    this.text.loading.text = original_text
                });
        },
        showConnectButton(){
            this.setAppStatus('show_auth')
            Nova.request().get('/nova-vendor/exact-online/authenticate')
                .then(response => {
                    this.auth_url = response.data.auth_url
                });
        },
        getCurrentUser (callback) {
            Nova.request().get('/nova-vendor/exact-online/me')
                .then(response => {
                    if (!response.data.success) {
                        this.showConnectButton()
                    } else {
                        this.user = response.data.user
                        this.visible_user_fields = response.data.visible_user_fields
                        this.setAppStatus('connected')
                        if (callback) {
                            callback(this)
                        }
                    }
                });
        }
    },

    mounted() {
        let vue = this;

        if (vue.$route.query.error) {
            vue.error = vue.$route.query.error
        }

        if (vue.$route.query.code) {
            this.setAppStatus('checking')

            Nova.request().get('/nova-vendor/exact-online/validate?code=' + vue.$route.query.code)
                .then(response => {
                    vue.getCurrentUser(function (vue) {
                        let query = Object.assign({}, vue.$route.query);
                        delete query.code;
                        vue.$router.replace({ query });
                        vue.$toasted.show(vue.text.connection_successfull_toaster, {type: "success"});
                    })
                
                }).catch(response => {
                    this.setAppStatus('show_auth')
                    this.text.connect_button_text = this.text.connect_retry
                    this.showConnectButton()
                });
        } else {
            vue.getCurrentUser()
        }
    }
}
</script>

<style>
/* Scoped Styles */
</style>