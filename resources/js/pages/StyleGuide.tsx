import InstitutionTarget from "@/components/InstitutionTarget";
import Carrusel from "@/components/carrusel";
import Navbar from "@/components/navbar";
import UploadImageButton from "@/components/Buttons/upload-image-button";
import FormInstitucion from "@/components/form-institucion";
import ListInstitutions from "@/components/list-institutions";
import CursosList from "@/components/modifyCourse"; // Cambiado el nombre a mayúscula

export default function StyleGuide() {
    
    const propsTargetInstitucion = {
        id: 1,
        backgroundImage: "/imagenes/FondoUniversidad.jpg",
        icon: "/imagenes/ItemUniversidad.png",
        name: "Universidad del Valle",
        enrolled: 199,
    };

    // Datos de ejemplo para cursos e instituciones
    const exampleCursos = [
        {
            id: "1",
            nombre: "Historia Antigua",
            descripcion: "Un estudio de las civilizaciones antiguas",
            institucion_id: "1",
            fecha_inicio: "2023-09-01"
        },
        {
            id: "2",
            nombre: "Introducción a la programación",
            descripcion: "Fundamentos de programación para principiantes",
            institucion_id: "1",
            fecha_inicio: "2023-10-15"
        }
    ];

    const exampleInstituciones = [
        {
            id: "1",
            nombre: "Universidad del Valle"
        },
        {
            id: "2",
            nombre: "Universidad Nacional"
        }
    ];

    // Función para manejar la actualización después de editar/eliminar
    const handleCursoUpdated = () => {
        console.log("Lista de cursos actualizada");
        // Aquí podrías hacer una llamada a tu API para refrescar los datos
    };

    return (
        <>
            <Navbar />
            <div className="pages text-[#1b1b18]">

                <div className="pt-20 p-6 lg:p-8">
                    <h1 className="text-3xl font-bold">Style Guide</h1>
                    <p className="mt-4">This is a style guide for the application.</p>
                    {/* Sección de colores */}
                    <h2 className="text-2xl font-semibold mt-8">Colors</h2>
                    <ul className="mt-4 space-y-2">
                        <li className="w-min px-4 py-2 bg-[#d4e5f7] text-white rounded-md shadow">#d4e5f7</li>
                        <li className="w-min px-4 py-2 bg-[#7eb2e7] text-black rounded-md shadow">#7eb2e7</li>
                        <li className="w-min px-4 py-2 bg-[#3357FF] text-white rounded-md shadow">#3357FF</li>
                    </ul>

                    {/* Sección de tipografía */}
                    <h2 className="text-2xl font-semibold mt-8">Typography</h2>
                    <p className="mt-4 text-lg">
                        This is a sample paragraph to demonstrate typography.
                    </p>
                </div>
                <UploadImageButton table="users" rowId={1} column="imagen_perfil" />
                <h2> Componente Target</h2>
                <InstitutionTarget props={propsTargetInstitucion} />
                <FormInstitucion />
                <Carrusel className="w-full max-w-[1100px] h-[350px]"
                    imagenes={[
                        "https://i.pinimg.com/736x/7f/ff/2b/7fff2be551c4e31b0bd1c648b10d2cb0.jpg",
                        "https://i.pinimg.com/736x/2a/9b/c1/2a9bc109983886b44ec21e21bf94ac51.jpg",
                        "https://i.pinimg.com/736x/b9/4b/41/b94b4168c6bd760c5364d5d0709be7da.jpg",
                        "https://i.pinimg.com/736x/e4/b0/d2/e4b0d2abea6b83c341e88af0cb57b264.jpg",
                        "https://i.pinimg.com/736x/e3/a9/65/e3a9657ada1a40d273e9ded3d111a7bd.jpg",
                    ]}
                    numSlide={2}>
                </Carrusel>
                <ListInstitutions />
                
                {/* Sección para el componente de cursos */}
                <div className="p-6 lg:p-8 border-t mt-8">
                    <h2 className="text-2xl font-semibold mb-6">Gestión de Cursos</h2>
                    <CursosList 
                        cursos={exampleCursos} 
                        instituciones={exampleInstituciones} 
                        onCursoUpdated={handleCursoUpdated} 
                    />
                </div>
            </div>
        </>
    )
}