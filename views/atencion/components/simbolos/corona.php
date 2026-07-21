 <!-- Corona -->
        <?php 
            $numero = $numero ?? 0;
        ?>
            <template x-if="hasSymbol(<?= $numero ?>,'corona')">

                <div
                    class="absolute inset-0 border-4 border-green-600 rounded pointer-events-none">
                </div>

            </template>