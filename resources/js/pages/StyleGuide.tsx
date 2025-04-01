import Carrusel from "@/components/carrusel";
import Navbar from "@/components/navbar";
import UploadImageButton from "@/components/Buttons/upload-image-button";
import { Upload } from "lucide-react";

export default function StyleGuide() {
    const propsNavbar = {
        profileImage: "/imagenes/Item.png",
    }

    return (
        <>
            <Navbar props={propsNavbar} />
            <div className="pages bg-white text-[#1b1b18] dark:bg-[#0a0a0a] overflow-y-auto">

                <div className="pt-20 p-6 lg:p-8">
                    <h1 className="text-3xl font-bold">Style Guide</h1>
                    <p className="mt-4">This is a style guide for the application.</p>

                    {/* Sección de colores */}
                    <h2 className="text-2xl font-semibold mt-8">Colors</h2>
                    <ul className="mt-4 space-y-2">
                        <li className="w-min px-4 py-2 bg-[#FF5733] text-white rounded-md shadow">#FF5733</li>
                        <li className="w-min px-4 py-2 bg-[#33FF57] text-black rounded-md shadow">#33FF57</li>
                        <li className="w-min px-4 py-2 bg-[#3357FF] text-white rounded-md shadow">#3357FF</li>
                    </ul>
                    <Carrusel className="w-full max-w-[1000px] h-[300px]"
                        imagenes={[
                            "https://i.pinimg.com/736x/7f/ff/2b/7fff2be551c4e31b0bd1c648b10d2cb0.jpg",
                            "https://i.pinimg.com/736x/2a/9b/c1/2a9bc109983886b44ec21e21bf94ac51.jpg",
                            "https://i.pinimg.com/736x/b9/4b/41/b94b4168c6bd760c5364d5d0709be7da.jpg",
                            "https://i.pinimg.com/736x/e4/b0/d2/e4b0d2abea6b83c341e88af0cb57b264.jpg",
                            "https://i.pinimg.com/736x/e3/a9/65/e3a9657ada1a40d273e9ded3d111a7bd.jpg",
                        ]}
                        numSlide={2}>
                    </Carrusel>
                    {/* Sección de tipografía */}
                    <h2 className="text-2xl font-semibold mt-8">Typography</h2>
                    <p className="mt-4 text-lg">
                        This is a sample paragraph to demonstrate typography.
                    </p>
                </div>
                <UploadImageButton table="users" rowId={1} column="imagen_perfil" />
            </div>
        </>
    )
}
