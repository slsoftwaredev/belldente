<!-- Pérdida por caries -->
        <?php 
            $numero = $numero ?? 0;
        ?>
             <template x-if="hasSymbol(<?= $numero ?>,'perdida_caries')">

                <div class="absolute inset-0">

                    <div
                        class="absolute top-1/2 left-0 w-full h-0.5 bg-blue-600 rotate-45 origin-center">
                    </div>

                    <div
                        class="absolute top-1/2 left-0 w-full h-0.5 bg-blue-600 -rotate-45 origin-center">
                    </div>

                </div>

            </template>