<!-- Ausente -->
        <?php
            $numero = $numero ?? 0;
        ?>
            <template x-if="hasSymbol(<?= $numero ?>,'ausente')">
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-xl font-bold text-slate-700">A</span>
                </div>
            </template>