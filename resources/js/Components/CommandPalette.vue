<script setup>
import { computed, ref, onMounted, onUnmounted } from 'vue'
import {
  Combobox,
  ComboboxInput,
  ComboboxOptions,
  ComboboxOption,
  Dialog,
  DialogPanel,
  TransitionRoot,
  TransitionChild,
} from '@headlessui/vue'
import { Search, Calculator, Calendar, CreditCard, Settings, User, FileText } from 'lucide-vue-next'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  modelValue: Boolean
})
const emit = defineEmits(['update:modelValue'])

const isOpen = computed({
  get: () => props.modelValue,
  set: (value) => emit('update:modelValue', value)
})

const query = ref('')

const navigation = [
  { name: 'Dashboard', href: route('dashboard'), icon: FileText },
  { name: 'Executive Dashboard', href: route('dashboard.executive'), icon: FileText },
  { name: 'Team Leader Dashboard', href: route('dashboard.team-leader'), icon: User },
  { name: 'Geo Head Dashboard', href: route('dashboard.geo-head'), icon: FileText },
  { name: 'VP Dashboard', href: route('dashboard.vp'), icon: FileText },
  { name: 'Admin Dashboard', href: route('dashboard.admin'), icon: Settings },
  { name: 'Profile', href: route('profile.edit'), icon: User },
]

const filteredItems = computed(() =>
  query.value === ''
    ? navigation
    : navigation.filter((item) => {
        return item.name.toLowerCase().includes(query.value.toLowerCase())
      })
)

function onSelect(item) {
  isOpen.value = false
  if (item.href) {
    router.visit(item.href)
  }
}

function onKeydown(event) {
  if (event.key === 'k' && (event.metaKey || event.ctrlKey)) {
    event.preventDefault()
    isOpen.value = !isOpen.value
  }
}

onMounted(() => {
  window.addEventListener('keydown', onKeydown)
})

onUnmounted(() => {
  window.removeEventListener('keydown', onKeydown)
})
</script>

<template>
  <TransitionRoot :show="isOpen" as="template" @after-leave="query = ''" appear>
    <Dialog as="div" class="relative z-50" @close="isOpen = false">
      <TransitionChild
        as="template"
        enter="ease-out duration-300"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="ease-in duration-200"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" />
      </TransitionChild>

      <div class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20">
        <TransitionChild
          as="template"
          enter="ease-out duration-300"
          enter-from="opacity-0 scale-95"
          enter-to="opacity-100 scale-100"
          leave="ease-in duration-200"
          leave-from="opacity-100 scale-100"
          leave-to="opacity-0 scale-95"
        >
          <DialogPanel
            class="mx-auto max-w-xl transform divide-y divide-gray-100 dark:divide-gray-800 overflow-hidden rounded-xl bg-white dark:bg-gray-900 shadow-2xl ring-1 ring-black ring-opacity-5 transition-all"
          >
            <Combobox @update:modelValue="onSelect">
              <div class="relative">
                <Search
                  class="pointer-events-none absolute left-4 top-3.5 h-5 w-5 text-gray-400"
                  aria-hidden="true"
                />
                <ComboboxInput
                  class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 focus:ring-0 sm:text-sm"
                  placeholder="Search..."
                  @change="query = $event.target.value"
                />
              </div>

              <ComboboxOptions
                v-if="filteredItems.length > 0"
                static
                class="max-h-96 scroll-py-3 overflow-y-auto p-3"
              >
                <ComboboxOption
                  v-for="item in filteredItems"
                  :key="item.name"
                  :value="item"
                  as="template"
                  v-slot="{ active }"
                >
                  <li
                    :class="[
                      'flex cursor-default select-none rounded-xl p-3',
                      active ? 'bg-primary-50 dark:bg-primary-900/20' : '',
                    ]"
                  >
                    <div
                      :class="[
                        'flex h-10 w-10 flex-none items-center justify-center rounded-lg',
                        active ? 'bg-primary-100 dark:bg-primary-800 text-primary-600 dark:text-primary-300' : 'bg-gray-100 dark:bg-gray-800 text-gray-500',
                      ]"
                    >
                      <component :is="item.icon" class="h-6 w-6" aria-hidden="true" />
                    </div>
                    <div class="ml-4 flex-auto">
                      <p
                        :class="[
                          'text-sm font-medium',
                          active ? 'text-gray-900 dark:text-gray-100' : 'text-gray-700 dark:text-gray-300',
                        ]"
                      >
                        {{ item.name }}
                      </p>
                      <p class="text-sm text-gray-500 dark:text-gray-400">Jump to {{ item.name }}</p>
                    </div>
                  </li>
                </ComboboxOption>
              </ComboboxOptions>

              <div
                v-if="query !== '' && filteredItems.length === 0"
                class="px-6 py-14 text-center text-sm sm:px-14"
              >
                <Search class="mx-auto h-6 w-6 text-gray-400" aria-hidden="true" />
                <p class="mt-4 font-semibold text-gray-900 dark:text-gray-100">No results found</p>
                <p class="mt-2 text-gray-500">
                  No components found for this search term. Please try again.
                </p>
              </div>
            </Combobox>
          </DialogPanel>
        </TransitionChild>
      </div>
    </Dialog>
  </TransitionRoot>
</template>
