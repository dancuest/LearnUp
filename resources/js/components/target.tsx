import fondo_usuario from "@/public/imagenes/fondo_usuario.jpg";

export default function target() {
    return (
        <div className="max-w-7/12  bg-white rounded-lg overflow-hidden shadow-lg">
            {/* Imagen de fondo */}
            <div
                className="h-32 bg-cover bg-center"
                style={{ backgroundImage: "url(${fondo_usuario.src})" }}
            ></div>

            {/* Contenido */}
            <div className="p-6 text-center justify-end">
                {/* Icono de usuario */}
                <div className="relative w-24 h-24  -mt-28">
                    <img
                        src="/ruta-de-tu-icono.png"
                        alt="User Icon"
                        className="w-full h-full object-cover rounded-full border-4 border-white shadow-md"
                    />
                </div>

                {/* Nombre de la universidad */}
                <h2 className="mt-4 text-xl font-semibold text-gray-900">Universidad Javeriana</h2>
                
                {/* Número de inscritos */}
                <p className="text-gray-700 text-sm mt-2">Número de Inscritos: 199</p>

                {/* Botón */}
                <button className="mt-4 bg-blue-700 text-white text-sm px-6 py-2 rounded-lg shadow-md hover:bg-blue-800 transition">
                    Inscribirse
                </button>
            </div>
        </div>
    );
}

