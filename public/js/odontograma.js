function toothComponent(numero){

    return{

        numero,

        menu:false,

        caraActual:null,

        caras:{

            vestibular:'sano',

            mesial:'sano',

            oclusal:'sano',

            distal:'sano',

            lingual:'sano'

        },

        estados:[

            {nombre:'Sano',color:'bg-white',valor:'sano'},

            {nombre:'Caries',color:'bg-red-500',valor:'caries'},

            {nombre:'Obturación',color:'bg-blue-500',valor:'obturado'},

            {nombre:'Corona',color:'bg-yellow-400',valor:'corona'},

            {nombre:'Endodoncia',color:'bg-green-500',valor:'endodoncia'},

            {nombre:'Ausente',color:'bg-gray-500',valor:'ausente'}

        ],

        abrir(cara){

            this.caraActual=cara;

            this.menu=true;

        },

        seleccionar(estado){

            this.caras[this.caraActual]=estado.valor;

            this.menu=false;

        },

        color(valor){

            switch(valor){

                case 'caries':

                    return 'bg-red-500';

                case 'obturado':

                    return 'bg-blue-500';

                case 'corona':

                    return 'bg-yellow-400';

                case 'endodoncia':

                    return 'bg-green-500';

                case 'ausente':

                    return 'bg-gray-500';

                default:

                    return 'bg-white';

            }

        }

    }

}