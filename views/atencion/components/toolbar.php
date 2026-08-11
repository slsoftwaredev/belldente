<div class="flex flex-wrap gap-3">

    <template x-for="item in herramientas">

        <button
            @click="tool=item.codigo"
            :class="tool==item.id ? item.active : item.normal"
            class="px-4 py-2 rounded-lg text-white font-semibold transition">

            <span x-text="item.nombre"></span>

        </button>

    </template>

</div>