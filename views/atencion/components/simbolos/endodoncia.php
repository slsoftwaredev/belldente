<!-- Endodoncia -->
        <?php 
            $numero = $numero ?? 0;
        ?>
            <template x-if="hasSymbol(<?= $numero ?>,'endodoncia')">

                <div class="absolute inset-0 flex items-center justify-center">

                    <div
                        class="w-0 h-0
                            border-l-[8px] border-l-transparent
                            border-r-[8px] border-r-transparent
                            border-b-[14px] border-b-orange-600">
                    </div>

                </div>

            </template>