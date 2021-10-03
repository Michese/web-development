<template>
  <label class="input__wrapper" :for="renderId">
    <div class="input">
      <input
        class="input__inner"
        :class="inputInnerClasses"
        :type="input.type"
        :name="input.name"
        :id="renderId"
        :value="getDisplay"
        @input="onInput"
      />
      <div class="input__label">
        <span class="crephusa"><slot></slot></span>
      </div>
    </div>
    <transition name="">
      <span v-show="showAlert" class="input__alert crephusa"> Некорректно введены данные </span>
    </transition>
  </label>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import { Prop, Emit, Watch } from 'vue-property-decorator';
import { TInput } from '@/types';

@Options({
  name: 'Input',
})
export default class Input extends Vue {
  @Prop({
    require: true,
  })
  private input!: TInput;
  @Prop({
    require: true,
  })
  private value!: string;
  display = '';

  created(): void {
    this.display = this.value;
  }

  isActivated = (this.value ?? '') !== '';
  @Emit() updatedInput(value: string): string {
    if (!this.isActivated && !!value) {
      this.isActivated = true;
    }
    return value;
  }
  @Watch('value') wValue(newValue: string): void {
    this.display = newValue;
  }
  @Watch('display') wDisplay(newValue: string): void {
    if (this.value !== newValue) {
      this.display = this.value;
    }
  }
  onInput(e: { isTrusted: boolean; target: { value: string } }): void {
    this.refresh(e.target.value);
  }
  phoneReplacer(str: string, p1: string, p2: string, p3: string, p4: string, p5: string): string {
    let result = p1 ? '+7' : '';
    result += p2 ? ` ${p2}` : '';
    result += p3 ? ` ${p3}` : '';
    result += p4 ? ` ${p4}` : '';
    result += p5 ? ` ${p5}` : '';
    return result;
  }
  refresh(value: string): void {
    this.display = value;
    if (this.input.type === 'tel') {
      value = value
        .replaceAll(/^\+7/g, '8')
        .replaceAll(/^[^8]+/g, '8$&')
        .replaceAll(/[^0-9]+/gi, '');
      if (value.length > 11) {
        return;
      }
    }
    this.updatedInput(value);
  }
  get getDisplay(): string {
    let newDisplay = this.display;
    if (this.input.type === 'tel') {
      newDisplay = this.display.replace(/(^8+)([0-9]{0,3})([0-9]{0,3})([0-9]{0,2})([0-9]{0,2})/gi, this.phoneReplacer);
    }
    return newDisplay;
  }
  get renderId(): string {
    return `id-${this.input.type}-${this.input.name}`;
  }
  get inputClasses(): { input__valid: boolean; input__invalid: boolean } {
    const inputIsValid = this.input.pattern.test(this.value);
    return {
      input__valid: this.isActivated && inputIsValid,
      input__invalid: this.isActivated && !inputIsValid,
    };
  }
  get inputInnerClasses(): { 'to-up': boolean } {
    return {
      'to-up': !!this.value,
    };
  }
  get showAlert(): boolean {
    return this.isActivated && !this.input.pattern.test(this.value);
  }
}
</script>

<style lang="scss" scoped>
.input {
  position: relative;
  padding: 30px 15px 15px;
  background: #f6f6f4;
  border: 1px solid #71631d;
  border-radius: 5px;
  box-shadow: 5px 5px 4px rgba(0, 0, 0, 0.25);

  &__wrapper {
    display: inline-block;
    width: 100%;
  }

  &__inner {
    width: 100%;
    color: var(--color-dark-green);
    background-color: transparent;
    border: none;
    outline: none;
  }

  &__label {
    position: absolute;
    top: 25px;
    left: 0;
    width: 100%;
    text-align: center;
    color: var(--color-light-green);
    transition: transform 0.1s ease;
  }

  &__inner:focus + &__label,
  .to-up + &__label {
    transform: translateY(-1.1em);
  }

  &__alert {
    color: var(--color-alert);
  }
}
</style>