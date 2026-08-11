function odontograma(){

    return{

        denticion:'permanente',

        tool:'caries',

        data:{},
        simbologias:[],
        piezasPermanentes:[],
        piezasTemporales:[],
        // Pieza donde comienza la selección de una prótesis
        protesisInicio:null,
        protesis:[],

// Orden visual de las piezas
ordenPermanenteSuperior:[
    18,17,16,15,14,13,12,11,
    21,22,23,24,25,26,27,28
],

ordenPermanenteInferior:[
    48,47,46,45,44,43,42,41,
    31,32,33,34,35,36,37,38
],

ordenTemporalSuperior:[
    55,54,53,52,51,
    61,62,63,64,65
],

ordenTemporalInferior:[
    85,84,83,82,81,
    71,72,73,74,75
],

        herramientas:[],

async init(){
    await this.cargarSimbologias();
    await this.cargarPiezas();
},
async cargarSimbologias(){

    try{

        const respuesta = await fetch(
            "../ajax/atencion.php?op=simbologias"
        );

        this.simbologias = await respuesta.json();
        this.construirHerramientas();

        console.log(
            "Odontograma - simbologías:",
            this.simbologias
        );

    }catch(error){

        console.error(
            "Error cargando simbologías:",
            error
        );

    }

},

//Construimos las simbologías como herramientas para el odontograma
construirHerramientas(){

    this.herramientas = this.simbologias.map(item => {

        const configuracion =
            this.configuracionSimbologia(
                item.nombre_simbologia
            );

        return {

            id: Number(item.id_simbologia),

            codigo: configuracion.codigo,

            nombre: item.nombre_simbologia,

            tipo: configuracion.tipo,

            color: item.color,

            simbolo: item.simbolo,

            active: configuracion.active,

            normal: configuracion.normal

        };

    });

    // Borrar no pertenece a la BDD.
    // Es únicamente una herramienta de la interfaz.
    this.herramientas.push({

        id:'borrar',
        codigo:'borrar',
        nombre:'Borrar',
        tipo:'borrar',
        active:'bg-gray-900',
        normal:'bg-gray-700'

    });

},
// Configuración de la simbología según su nombre
configuracionSimbologia(nombre){

    const configuraciones = {

        'Caries': {
            codigo:'caries',
            tipo:'cara',
            active:'bg-red-700',
            normal:'bg-red-500'
        },

        'Obturado': {
            codigo:'obturacion',
            tipo:'cara',
            active:'bg-blue-700',
            normal:'bg-blue-500'
        },

        'Corona Indicada': {
            codigo:'corona_indicada',
            tipo:'simbolo',
            active:'bg-red-700',
            normal:'bg-red-500'
        },

        'Corona Realizada': {
            codigo:'corona_realizada',
            tipo:'simbolo',
            active:'bg-blue-700',
            normal:'bg-blue-500'
        },

        'Endodoncia por Realizar': {
            codigo:'endodoncia_requerida',
            tipo:'simbolo',
            active:'bg-red-700',
            normal:'bg-red-500'
        },

        'Endodoncia Realizada': {
            codigo:'endodoncia_realizada',
            tipo:'simbolo',
            active:'bg-blue-700',
            normal:'bg-blue-500'
        },

        'Extracción Indicada': {
            codigo:'extraccion',
            tipo:'simbolo',
            active:'bg-red-700',
            normal:'bg-red-500'
        },

        'Pérdida por Caries': {
            codigo:'perdida_caries',
            tipo:'simbolo',
            active:'bg-blue-700',
            normal:'bg-blue-500'
        },

        'Pérdida por Otra Causa': {
            codigo:'perdida_otra',
            tipo:'simbolo',
            active:'bg-gray-900',
            normal:'bg-gray-700'
        },

        'Sellante Necesario': {
            codigo:'sellante_necesario',
            tipo:'simbolo',
            active:'bg-red-700',
            normal:'bg-red-500'
        },

        'Sellante Realizado': {
            codigo:'sellante_realizado',
            tipo:'simbolo',
            active:'bg-blue-700',
            normal:'bg-blue-500'
        },

        'Prótesis Fija Indicada': {
            codigo:'protesis_fija_indicada',
            tipo:'simbolo',
            active:'bg-red-700',
            normal:'bg-red-500'
        },

        'Prótesis Fija Realizada': {
            codigo:'protesis_fija_realizada',
            tipo:'simbolo',
            active:'bg-blue-700',
            normal:'bg-blue-500'
        },

        'Prótesis Removible Indicada': {
            codigo:'protesis_removible_indicada',
            tipo:'simbolo',
            active:'bg-red-700',
            normal:'bg-red-500'
        },

        'Prótesis Removible Realizada': {
            codigo:'protesis_removible_realizada',
            tipo:'simbolo',
            active:'bg-blue-700',
            normal:'bg-blue-500'
        },

        'Prótesis Total Indicada': {
            codigo:'protesis_total_indicada',
            tipo:'simbolo',
            active:'bg-red-700',
            normal:'bg-red-500'
        },

        'Prótesis Total Realizada': {
            codigo:'protesis_total_realizada',
            tipo:'simbolo',
            active:'bg-blue-700',
            normal:'bg-blue-500'
        },

        'Ausente': {
            codigo:'ausente',
            tipo:'simbolo',
            active:'bg-gray-900',
            normal:'bg-gray-700'
        }

    };

    return configuraciones[nombre] ?? {
        codigo:'',
        tipo:'simbolo',
        active:'bg-gray-700',
        normal:'bg-gray-500'
    };

},

async cargarPiezas(){

    try{

        // Dentición permanente
        let respuesta = await fetch(
            "../ajax/atencion.php?op=piezas&tipo_denticion=1"
        );

        this.piezasPermanentes =
            await respuesta.json();


        // Dentición temporal
        respuesta = await fetch(
            "../ajax/atencion.php?op=piezas&tipo_denticion=2"
        );

        this.piezasTemporales =
            await respuesta.json();


        console.log(
            "Odontograma - permanentes:",
            this.piezasPermanentes
        );

        console.log(
            "Odontograma - temporales:",
            this.piezasTemporales
        );

    }catch(error){

        console.error(
            "Error cargando piezas:",
            error
        );

    }

},
        // Iniciamos el odontograma
        initTooth(pieza){

            if(this.data[pieza]) return;

            this.data[pieza]={

                caras:{
                    superior:null,
                    izquierda:null,
                    oclusal:null,
                    derecha:null,
                    inferior:null
                },

                simbolos:[]

            };

        },

        // ==========================================
// CONTROL DEL CLIC SOBRE EL DIENTE
// ==========================================
        clickDiente(pieza, cara){

    const herramienta = this.herramientas.find(
        h => h.codigo === this.tool
    );

    if(!herramienta) return;
    // Si seleccionamos Borrar
if(herramienta.tipo === 'borrar'){

    this.borrarPieza(pieza);

    return;
}

    const protesis = [
        'protesis_fija_indicada',
        'protesis_fija_realizada',
        'protesis_removible_indicada',
        'protesis_removible_realizada',
        'protesis_total_indicada',
        'protesis_total_realizada'
    ];

    // Si estamos trabajando con una prótesis
    if(protesis.includes(herramienta.codigo)){

        this.seleccionarProtesis(pieza);
        return;

    }

    // Para las demás herramientas
    this.paint(pieza,cara);

},
// ==========================================
// OBTENER RANGO DE PIEZAS PARA PRÓTESIS
// ==========================================
obtenerRangoProtesis(inicio, fin){

    const arcadas = [

        this.ordenPermanenteSuperior,
        this.ordenPermanenteInferior,
        this.ordenTemporalSuperior,
        this.ordenTemporalInferior

    ];

    for(const arcada of arcadas){

        const posicionInicio = arcada.indexOf(inicio);
        const posicionFin = arcada.indexOf(fin);

        // Ambas piezas deben pertenecer
        // a la misma arcada
        if(
            posicionInicio !== -1 &&
            posicionFin !== -1
        ){

            const desde = Math.min(
                posicionInicio,
                posicionFin
            );

            const hasta = Math.max(
                posicionInicio,
                posicionFin
            );

            return arcada.slice(
                desde,
                hasta + 1
            );

        }

    }

    return [];

},

//===========================================
//OBTENER ARCADA COMPLETA
//===========================================
obtenerArcadaCompleta(pieza){

    const arcadas = [
        this.ordenPermanenteSuperior,
        this.ordenPermanenteInferior,
        this.ordenTemporalSuperior,
        this.ordenTemporalInferior
    ];

    for(const arcada of arcadas){

        if(arcada.includes(pieza)){
            return [...arcada];
        }

    }

    return [];

},

// ==========================================
// SELECCIONAR RANGO DE PRÓTESIS
// ==========================================
seleccionarProtesis(pieza){

    const herramienta = this.herramientas.find(
        h => h.codigo === this.tool
    );

    if(!herramienta) return;

    const protesis = [
        'protesis_fija_indicada',
        'protesis_fija_realizada',
        'protesis_removible_indicada',
        'protesis_removible_realizada',
        'protesis_total_indicada',
        'protesis_total_realizada'
    ];

        // ==========================================
    // PRÓTESIS TOTAL
    // Un clic selecciona toda la arcada
    // ==========================================
    if(
        herramienta.codigo === 'protesis_total_indicada' ||
        herramienta.codigo === 'protesis_total_realizada'
    ){

        const piezasSeleccionadas =
            this.obtenerArcadaCompleta(pieza);

        if(piezasSeleccionadas.length === 0){
            return;
        }

        this.protesis.push({

            tipo: herramienta.codigo,
            piezas: piezasSeleccionadas

        });

        console.log(
            'Prótesis total:',
            herramienta.codigo,
            piezasSeleccionadas
        );

        this.protesisInicio = null;

        return;
    }

    // Si la herramienta seleccionada no es una prótesis
    if(!protesis.includes(herramienta.codigo)){
        return;
    }

    // Primer clic
    if(this.protesisInicio === null){

        this.protesisInicio = pieza;

        console.log(
            'Inicio de prótesis:',
            pieza
        );

        return;
    }

    // Segundo clic
    const inicio = this.protesisInicio;
const fin = pieza;

const piezasSeleccionadas =
    this.obtenerRangoProtesis(inicio, fin);

if(piezasSeleccionadas.length === 0){

    console.warn(
        'Las piezas seleccionadas no pertenecen a la misma arcada'
    );

    this.protesisInicio = null;

    return;
}

console.log(
    'Prótesis seleccionada:',
    inicio,
    fin,
    herramienta.codigo
);

console.log(
    'Piezas de la prótesis:',
    piezasSeleccionadas
);
this.protesis.push({

    tipo: herramienta.codigo,
    piezas: piezasSeleccionadas

});

console.log(
    'Prótesis guardadas:',
    this.protesis
);

this.protesisInicio = null;


},

hasProtesis(pieza, tipo){

    return this.protesis.some(protesis =>

        protesis.tipo === tipo &&
        protesis.piezas.includes(pieza)

    );

},

esInicioProtesis(pieza, tipo){

    return this.protesis.some(protesis =>

        protesis.tipo === tipo &&
        protesis.piezas[0] === pieza

    );

},

esFinProtesis(pieza, tipo){

    return this.protesis.some(protesis =>

        protesis.tipo === tipo &&
        protesis.piezas[
            protesis.piezas.length - 1
        ] === pieza

    );

},

//Borras protesis y símbolos de la pieza dental
borrarPieza(pieza){

    // Borra símbolos y superficies normales
    if(this.data[pieza]){
        delete this.data[pieza];
    }

    // Borra cualquier prótesis que incluya esta pieza
    this.protesis = this.protesis.filter(
        protesis => !protesis.piezas.includes(pieza)
    );

},

    //   Pintamos la pieza dental
                paint(pieza,cara){

            this.initTooth(pieza);

            const herramienta = this.herramientas.find(
                h => h.codigo === this.tool
            );

            if(!herramienta) return;

            switch(herramienta.tipo){
                case 'borrar':
                    //   Borramos la pieza dental del odontograma
                    delete this.data[pieza];

                break;

                case 'cara':
                //No permitir que se agregue un símbolo si la pieza está ausente o perdida
                if(
                        this.hasSymbol(pieza,'ausente') ||
                        this.hasSymbol(pieza,'perdida_caries') ||
                        this.hasSymbol(pieza,'perdida_otra')
                    ){
                        return;
                    }
                    //   Pintamos la cara de la pieza dental
                    this.data[pieza].caras[cara]=herramienta.codigo;
                    

                break;

                case 'simbolo':
                    const exclusivos=[
                        'ausente',
                        'extraccion',
                        'perdida_caries',
                        'perdida_otra'
                    ];
                    if(exclusivos.includes(herramienta.codigo)){
                        this.replaceExclusiveSymbol(pieza,herramienta.codigo);
                    }else{

                    if(!this.data[pieza].simbolos.includes(herramienta.codigo)){

                        this.data[pieza].simbolos.push(herramienta.codigo);

                        }
                    }

                break;

            }

        },
        //   Obtenemos el color de la superficie
        surfaceClass(pieza,cara){

            if(!this.data[pieza]){

                return 'bg-white';

            }

            const estado = this.data[pieza].caras[cara];

            if(!estado){

                return 'bg-white';

            }

            switch(estado){

                case 'caries':

                    return 'bg-red-500';

                case 'obturacion':

                    return 'bg-blue-500';

                default:

                    return 'bg-white';

            }

        },

        //   Obtenemos el símbolo de la pieza dental
        getSymbol(pieza){

            if(!this.data[pieza]) return '';

            if(!this.data[pieza].simbolos.length) return '';

            const simbolo = this.data[pieza].simbolos[0];

            switch(simbolo){

                case 'ausente':
                    return 'A';

                case 'corona':
                    return '□';

                case 'endodoncia':
                    return '△';

                default:
                    return '';

            }

        },
        //   Verificamos si la pieza dental tiene un símbolo específico
        hasSymbol(pieza, simbolo){

            if(!this.data[pieza]) return false;

            return this.data[pieza].simbolos.includes(simbolo);

        },

        //  Reemplazamos un símbolo exclusivo en la pieza dental
        replaceExclusiveSymbol(pieza,nuevo){

            const exclusivos=[
                'ausente',
                'extraccion',
                'perdida_caries',
                'perdida_otra'
            ];

            this.data[pieza].simbolos =
                this.data[pieza].simbolos.filter(
                    s => !exclusivos.includes(s)
                );

            this.data[pieza].simbolos.push(nuevo);

        }

    }

}