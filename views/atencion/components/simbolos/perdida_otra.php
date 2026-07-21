<!--Pérdida por otra causa -->
        <?php 
            $numero = $numero ?? 0;
        ?>
            <template x-if="hasSymbol(<?= $numero ?>,'perdida_otra')">

                <div class="absolute inset-0">

                    <div
                        class="absolute top-1/2 left-0 w-full h-0.5 bg-black rotate-45 origin-center">
                    </div>

                    <div
                        class="absolute top-1/2 left-0 w-full h-0.5 bg-black -rotate-45 origin-center">
                    </div>

                </div>

            </template>