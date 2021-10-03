<template>
  <button type="button" class="auth-modal__btn" @click="openModal">
    <slot></slot>
  </button>

  <teleport to="body">
    <transition name="modal">
      <div v-if="isOpen" class="auth-modal" @click.self="closeModal">
        <section class="auth-modal__inner">

        </section>
      </div>
    </transition>
  </teleport>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';

@Options({
  name: 'AuthModal',
})
export default class AuthModal extends Vue {
  isOpen = false;

  openModal(): void {
    this.isOpen = true;
  }

  closeModal(): void {
    this.isOpen = false;
  }
}
</script>

<style lang="scss" scoped>
@import '/assets/css/media';
.modal-enter-active,
.modal-leave-active {
  transition-duration: 0.6s;
  transition-timing-function: ease-in-out;
  transition-property: transform, opacity;
}

.modal-enter-from {
  opacity: 0;
  transform: translateY(-50%);
}

.modal-leave-to {
  opacity: 0;
  transform: translateY(50%);
}

.auth-modal {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 10px;
  z-index: 100;
  background-color: rgba(#3b3b3b, 0.8);

  &__btn {
    cursor: pointer;
  }

  &__inner {
    padding: 15px;
    background-color: rgba(#f3da6b, 0.65);
  }
}
</style>
