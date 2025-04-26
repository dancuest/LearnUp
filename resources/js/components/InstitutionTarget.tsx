interface InstitutionTargetProps {
    backgroundImage: string | File;
    icon: string;
    name: string;
    enrolled: number;
}

export default function InstitutionTarget({ props }: { props: InstitutionTargetProps }) {
    const { backgroundImage, icon, name, enrolled }: InstitutionTargetProps = props;

    return (
        <div className="w-[300px] bg-white dark:bg-gray-700 rounded-lg overflow-hidden shadow-lg flex flex-col">
            <div
                className="h-[80px] bg-cover bg-center"
                style={{ backgroundImage: `url(${backgroundImage})` }}
            >
                <div className="w-[70px] h-[70px] ml-2.5 mt-2">
                    <img
                        src={icon}
                        alt="Icono de Universidad"
                        className="w-full h-full object-cover rounded-full border-4 border-white dark:border-gray-700 shadow-md"
                    />
                </div>
            </div>
            <div className="flex w-full h-fit flex-col items-center justify-center text-center mb-4 mt-2 px-3">
                <h2 className="flex justify-around text-xl font-semibold text-gray-900 dark:text-gray-100">{name}</h2>
                <p className="text-gray-700 dark:text-gray-300 text-sm">Número de Inscritos: {enrolled}</p>
                <button className="bg-blue-700 dark:bg-blue-600 text-white text-sm mt-2 px-6 py-2 rounded-lg shadow-md hover:bg-blue-800 dark:hover:bg-blue-700 transition">
                    Inscribirse
                </button>
            </div>
        </div>
    );
}