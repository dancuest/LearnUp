interface TargetProps {
    backgroundImage: string | File;
    icon: string | File;
    name: string;
    enrolled: number;
}

export default function Target({props}: { props: TargetProps }) {
    const { backgroundImage, icon, name, enrolled }: TargetProps= props
    
    return (
        <div className="w-[350px] bg-white rounded-lg overflow-hidden shadow-lg">
            <div
                className="h-[70px] bg-cover bg-center"
                style={{ backgroundImage: `url(${backgroundImage})` }}
            ></div>

            <div className="p-4 text-center -mt-6">
                
                <div className="relative w-[110px] h-[110px] -mt-[30px] mx-auto -ml-2.5">
                    <img
                        src={typeof icon === 'string' ? icon : URL.createObjectURL(icon)}
                        alt="Icono de Universidad"
                        className="w-full h-full object-cover rounded-full border-4 border-white shadow-md"
                    />
                </div>

                <h2 className="flex justify-around text-xl font-semibold text-gray-900 -mt-16 ml-26">{name}</h2>

                <p className="text-gray-700 text-sm ml-25">Número de Inscritos: {enrolled}</p>

                <button className="bg-blue-700 text-white text-sm mt-2 px-6 py-2 rounded-lg shadow-md hover:bg-blue-800 transition ml-25">
                    Inscribirse
                </button>
            </div>
        </div>
    );
}
