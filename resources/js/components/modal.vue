<template>
  <transition name="modal" appear>
    <div class="modal modal-overlay">
        <!-- <div class="modal modal-overlay" @click.self="$emit('close')"> -->
      <div class="modal-window">
        <div class="modal-content">
          <slot/>
        </div>
        <footer class="modal-footer">
          <slot name="footer">
            <!-- <button @click="$emit('close')">Close</button> -->
            <button>Close</button>
          </slot>
        </footer>
      </div>
    </div>
  </transition>
</template>
<script>
// import { defineComponent } from '@vue/composition-api'

export default {
    name: "modal"
}
</script>
