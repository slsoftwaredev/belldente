<?php
$numero = $numero ?? 0;
?>

<!-- =========================================
     CORONA INDICADA - ROJO
========================================= -->
<template x-if="hasSymbol(<?= $numero ?>,'corona_indicada')">

    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">

        <div class="w-11 h-11 border-[3px] border-red-600
                    flex items-center justify-center">

            <div class="w-8 h-8 border-[3px] border-red-600
                        flex items-center justify-center">

                <div class="w-5 h-5 border-[3px] border-red-600
                            flex items-center justify-center">

                    <div class="w-2 h-2 bg-red-600"></div>

                </div>

            </div>

        </div>

    </div>

</template>


<!-- =========================================
     CORONA REALIZADA - AZUL
========================================= -->
<template x-if="hasSymbol(<?= $numero ?>,'corona_realizada')">

    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">

        <div class="w-11 h-11 border-[3px] border-blue-700
                    flex items-center justify-center">

            <div class="w-8 h-8 border-[3px] border-blue-700
                        flex items-center justify-center">

                <div class="w-5 h-5 border-[3px] border-blue-700
                            flex items-center justify-center">

                    <div class="w-2 h-2 bg-blue-700"></div>

                </div>

            </div>

        </div>

    </div>

</template>