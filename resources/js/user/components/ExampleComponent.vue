<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
      props: {
        valueName: {
          type: String,
          required: false // или тру если это обяз параметр для компонета. а дальше везде тупо this.valueName
        }
      },
      mounted() {
          console.log('Component mounted.')
      }
    }
</script>
