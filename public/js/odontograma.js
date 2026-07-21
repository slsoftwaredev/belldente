function odontograma(){

    return{

        denticion:'permanente',

        tool:'caries',

        data:{},

        herramientas:[

            {
                id:'caries',
                nombre:'Caries',
                tipo: 'cara',
                active:'bg-red-700',
                normal:'bg-red-500'
            },

            {
                id:'obturacion',
                nombre:'Obturación',
                tipo: 'cara',
                active:'bg-blue-700',
                normal:'bg-blue-500'
            },

            {
                id:'corona',
                nombre:'Corona',
                tipo: 'simbolo',
                active:'bg-yellow-600',
                normal:'bg-yellow-400 text-black'
            },

            {
                id:'endodoncia',
                nombre:'Endodoncia',
                tipo: 'simbolo',
                active:'bg-green-700',
                normal:'bg-green-500'
            },

            {
                id:'ausente',
                nombre:'Ausente',
                tipo: 'simbolo',
                active:'bg-slate-800',
                normal:'bg-slate-500'
            },
            {
                id:'extraccion',
                nombre:'Extracción',
                tipo:'simbolo',
                active:'bg-red-800',
                normal:'bg-red-600'
            },
            {
                id:'perdida_caries',
                nombre:'Pérdida por caries',
                tipo:'simbolo',
                active:'bg-blue-800',
                normal:'bg-blue-600'
            },

            {
                id:'perdida_otra',
                nombre:'Pérdida por otra causa',
                tipo:'simbolo',
                active:'bg-gray-800',
                normal:'bg-gray-600'
            },
            {
                id:'borrar',
                nombre:'Borrar',
                tipo:'borrar',
                active:'bg-gray-900',
                normal:'bg-gray-700'
            },

        ],

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

    //   Pintamos la pieza dental
                paint(pieza,cara){

            this.initTooth(pieza);

            const herramienta = this.herramientas.find(
                h => h.id === this.tool
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
                    this.data[pieza].caras[cara]=herramienta.id;
                    

                break;

                case 'simbolo':
                    const exclusivos=[
                        'ausente',
                        'extraccion',
                        'perdida_caries',
                        'perdida_otra'
                    ];
                    if(exclusivos.includes(herramienta.id)){
                        this.replaceExclusiveSymbol(pieza,herramienta.id);
                    }else{

                    if(!this.data[pieza].simbolos.includes(herramienta.id)){

                        this.data[pieza].simbolos.push(herramienta.id);

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
        replaceExclusiveSymbol(pieza, nuevo){

            const exclusivos = [
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