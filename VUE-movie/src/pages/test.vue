// An highlighted block
<template>
  <div>
    <div style="display: inline-block"
         v-for="(num,index) in 5" :key="index" @click="handle(num)">
      <img :src='data>=index?ling:bu' alt="">
    </div>
  </div>
</template>


// An highlighted block
<script>
import img from '../img/1.png'
import imgB from '../img/0.png'
export default {
  data() {
    return {
      data:3,
      bu:imgB,
      ling:img
    }
  },
  methods:{
    handle(val){
      console.log(val)
      alert(val)
      this.data = 0
      this.data = val
    }
  }
}
</script>

<style scoped>
</style>
