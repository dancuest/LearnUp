
export default function target() {
    return (
        <div className="max-w-7/12  bg-white rounded-lg overflow-hidden shadow-lg">
            {/* Imagen de fondo */}
            <div
                className="h-20 bg-cover bg-center"
                style={{ backgroundImage: "url('/imagenes/FondoUniversidad.jpg')"  }}
            ></div>

            {/* Contenido */}
            <div className="p-4  text-center -mt-6">
                {/* Icono de usuario */}
                <div className="relative w-24 h-24  -mt-14">
                    <img
                        src='/imagenes/itemUniversidad.png'
                        alt="User Icon"
                        className="w-full h-full object-cover rounded-full border-4 border-white shadow-md"
                    />
                </div>

                {/* Nombre de la universidad */}
                <h2 className=" text-xl font-semibold text-gray-900 ">Universidad Javeriana</h2>
                
                {/* Número de inscritos */}
                <p className="text-gray-700 text-sm mt-2">Número de Inscritos: 199</p>

                {/* Botón */}
                <button className=" bg-blue-700 text-white text-sm mt-2 px-6 py-2 rounded-lg shadow-md hover:bg-blue-800 transition">
                    Inscribirse
                </button>
            </div>
        </div>
    );
}

