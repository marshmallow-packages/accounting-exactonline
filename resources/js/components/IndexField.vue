<template>
    <span v-if="field.value" title="Available in Exact Online">
    	<svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40"><path fill="#E1141D" d="M26.6,26.1h-8c-3.8,0-5.6-1.4-6.1-4.8h11.8v0h4.1v-1.2c0,0,0-0.1,0-0.1v-4.1c0,0,0-0.1,0-0.1v-1.2h-1.2
		c0,0-0.1,0-0.1,0H12.5c0.5-3.5,2.2-5,6.1-5h12V2.8h-3.6v0h-9.2C8.5,2.8,5,7.5,5,17.8c0,10.3,3.6,15,12.9,15h11.6c0,0,0,0,0,0h1.3
		v-6.8C30.8,26.1,26.6,26.1,26.6,26.1z"/></svg>
    </span>
    <span v-else title="Not available in Exact Online">
    	<svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40"><path fill="#cccccc" d="M26.6,26.1h-8c-3.8,0-5.6-1.4-6.1-4.8h11.8v0h4.1v-1.2c0,0,0-0.1,0-0.1v-4.1c0,0,0-0.1,0-0.1v-1.2h-1.2
		c0,0-0.1,0-0.1,0H12.5c0.5-3.5,2.2-5,6.1-5h12V2.8h-3.6v0h-9.2C8.5,2.8,5,7.5,5,17.8c0,10.3,3.6,15,12.9,15h11.6c0,0,0,0,0,0h1.3
		v-6.8C30.8,26.1,26.6,26.1,26.6,26.1z"/></svg>
    </span>
</template>

<script>
export default {
    props: ['resourceName', 'field'],

    mounted() {
        let vue = this;
    }
}
</script>
