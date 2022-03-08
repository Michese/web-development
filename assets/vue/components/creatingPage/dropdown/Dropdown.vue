<template>
  <div class="dropdown" :class="dropdownClasses" v-clickoutside="close" @click="show = !show">
    <span class="dropdown__selected-title">{{ selectedItem?.title || 'Тематика' }}</span>
    <div class="dropdown__icon"></div>
    <ul v-show="show" class="dropdown__list">
      <li v-for="item in showSelectedList" class="dropdown__item" :key="item.id" @click="onSelect(item)">{{ item.title }}</li>
    </ul>
  </div>
</template>

<script lang="ts">
import { Options, Vue } from 'vue-class-component';
import { Emit, Prop } from 'vue-property-decorator';
import { TDropdownItem } from '@/vue/components/creatingPage/dropdown/types';

@Options({
  name: 'Dropdown',
})
export default class Dropdown extends Vue {
  show = false;

  @Prop({
    type: Object as () => TDropdownItem,
    required: false,
  })
  selectedItem!: TDropdownItem;

  @Prop({
    type: Array as () => TDropdownItem[],
    required: false,
    default: () => [],
  })
  selectList!: TDropdownItem[];

  @Emit('on-select') onSelect(selectedItem: TDropdownItem): TDropdownItem {
    this.close();
    return selectedItem;
  }

  get showSelectedList(): TDropdownItem[] {
    return this.selectedItem ? this.selectList.filter((item) => item.id !== this.selectedItem.id) : this.selectList;
  }

  get dropdownClasses(): { dropdown_open: boolean } {
    return {
      dropdown_open: this.show,
    };
  }

  close(): void {
    this.show = false;
  }
}
</script>

<style lang="scss" scoped>
.dropdown {
  display: flex;
  justify-content: space-between;
  position: relative;
  padding: 15px;
  background-color: rgba(157, 161, 87, 0.72);
  border-radius: 5px;
  cursor: pointer;

  &_open {
    background-color: rgba(157, 161, 87, 0.9);
  }

  &__selected-title {
    color: #e5e4d9;
  }

  &__icon {
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    height: 1.11em;
    width: 1.11em;
    border-radius: 50%;
    color: #e5e4d9;
    border: 2px solid currentColor;
    box-shadow: 0 0 2px rgb(70, 69, 18);

    &:before {
      display: block;
      position: absolute;
      content: '';
      height: 0.5em;
      width: 0.5em;
      color: currentColor;
      border-left: 2px solid currentColor;
      border-bottom: 2px solid currentColor;
      transform-origin: 40% 50%;
      transform: rotate(-45deg);
    }
  }

  &__list {
    position: absolute;
    top: 102%;
    right: 0;
    left: 0;
    background-color: rgba(157, 161, 87, 0.9);
    border-radius: 5px;
  }

  &__item {
    padding: 6px 15px;
    font-weight: 600;
    font-size: 18px;
    line-height: 22px;
    color: #e5e4d9;

    &:hover {
      color: #464512;
    }
  }
}
</style>