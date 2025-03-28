import Navbar from "@/components/navbar";

export default function StyleGuide() {
    return (
        <div className="min-h-screen bg-white text-[#1b1b18] dark:bg-[#0a0a0a]">
            <Navbar />

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

                {/* Sección de tipografía */}
                <h2 className="text-2xl font-semibold mt-8">Typography</h2>
                <p className="mt-4 text-lg">
                    This is a sample paragraph to demonstrate typography.
                </p>
            </div>
        </div>
    );
}
