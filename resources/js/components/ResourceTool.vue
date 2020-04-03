<template>
  	<div>
  		<div class="flex items-center mb-3">
	  		<svg id="exact-online-status-icon" class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40"><path :fill="colorAttr()" d="M26.6,26.1h-8c-3.8,0-5.6-1.4-6.1-4.8h11.8v0h4.1v-1.2c0,0,0-0.1,0-0.1v-4.1c0,0,0-0.1,0-0.1v-1.2h-1.2
			c0,0-0.1,0-0.1,0H12.5c0.5-3.5,2.2-5,6.1-5h12V2.8h-3.6v0h-9.2C8.5,2.8,5,7.5,5,17.8c0,10.3,3.6,15,12.9,15h11.6c0,0,0,0,0,0h1.3
			v-6.8C30.8,26.1,26.6,26.1,26.6,26.1z"/></svg>
  			<h1 class="flex-no-shrink text-90 font-normal text-2xl">
  				Exact online details
  			</h1>
  		</div>
	    <div class="card mb-6 py-3 px-6">
	    	<div v-if="is_loading" class="text-center">
		    	<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
		    </div>
        <div v-for="field in this.fields" class="flex border-b border-40">
            <div class="w-1/4 py-4">
                <h4 class="font-normal text-80">{{ field }}</h4>
            </div> 
            <div class="w-3/4 py-4 break-words">
                <p class="text-90">
                    {{ data[field] }}
                </p>
            </div>
        </div>
        <div v-if="error">
          <p class="text-80">
            {{ error }}
          </p>
        </div>
	    </div>
	</div>
</template>

<script>
export default {
  	props: ['resourceName', 'resourceId', 'panel'],

  	data () {
        return {
            data: null,
            fields: null,
            is_loading: true,
            error: null,
            icon_color: '#ccc'
            // icon_color: '#E1141D'
        }
    },
    methods:{
        colorAttr(color = '#ccc') {
          return color
        }
    },

  	mounted() {
        let vue = this;

        Nova.request().post('/nova-vendor/exact-online/show', {
        	'resourceName': this.resourceName, 
        	'resourceId': this.resourceId,
        	'model': this.panel.fields[0].model
        })
            .then(response => {
              if (response.data.data) {
                this.data = response.data.data
                this.fields = response.data.fields
                this.colorAttr('#E1141D')
              } else {
                this.error = response.data.error
              }
            	this.is_loading = false
            }).catch(response => {
              
            });
    },
}
</script>
<style>


</style>