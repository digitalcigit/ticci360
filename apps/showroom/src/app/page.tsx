import Link from "next/link";
import { Button } from "@/components/ui/button";
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { ArrowRight, ShieldCheck, Truck, Headphones, Briefcase, Cpu, Network } from "lucide-react";

export default function Home() {
  return (
    <div className="flex flex-col min-h-screen">
      {/* Hero Section */}
      <section className="relative bg-zinc-900 text-white py-24 px-6 md:px-12 lg:px-24 overflow-hidden">
        <div className="absolute inset-0 bg-[url('/grid-pattern.svg')] opacity-10 pointer-events-none" />
        <div className="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center relative z-10">
          <div className="space-y-6">
            <Badge variant="secondary" className="px-3 py-1 text-sm font-medium tracking-wide">
              PARTENAIRE EXPERT
            </Badge>
            <h1 className="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight">
              Votre tranquillité numérique, <span className="text-blue-400">notre métier.</span>
            </h1>
            <p className="text-lg md:text-xl text-gray-300 max-w-2xl">
              Plus qu'un simple fournisseur, TICCI vous accompagne avec une expertise d'ingénieur. 
              Matériel informatique, réseaux et solutions pour entreprises et particuliers.
            </p>
            <div className="flex flex-col sm:flex-row gap-4 pt-4">
              <Button asChild size="lg" className="bg-blue-600 hover:bg-blue-700 text-white">
                <Link href="/products">
                  Voir le catalogue
                  <ArrowRight className="ml-2 h-4 w-4" />
                </Link>
              </Button>
              <Button asChild variant="outline" size="lg" className="bg-transparent border-white text-white hover:bg-white/10 hover:text-white">
                <Link href="/quote">
                  Demander un devis PRO
                </Link>
              </Button>
            </div>
          </div>
          <div className="hidden lg:block relative">
            <div className="absolute -inset-4 bg-blue-500/20 rounded-full blur-3xl opacity-50" />
            {/* Placeholder for Hero Image - Could be a server rack or modern workspace */}
            <div className="relative bg-zinc-800 rounded-2xl border border-zinc-700 p-8 shadow-2xl">
              <div className="flex items-center gap-4 mb-6">
                <div className="h-12 w-12 rounded-full bg-blue-500/20 flex items-center justify-center">
                  <ShieldCheck className="h-6 w-6 text-blue-400" />
                </div>
                <div>
                  <h3 className="font-bold text-lg">Garantie TICCI</h3>
                  <p className="text-sm text-gray-400">Support local réactif</p>
                </div>
              </div>
              <div className="space-y-4">
                <div className="h-2 bg-zinc-700 rounded w-3/4" />
                <div className="h-2 bg-zinc-700 rounded w-1/2" />
                <div className="h-2 bg-zinc-700 rounded w-5/6" />
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Réassurance - Trust Signals */}
      <section className="bg-zinc-50 border-b border-zinc-200 py-12">
        <div className="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">
          <div className="flex items-start gap-4 p-4">
            <div className="p-3 bg-white rounded-lg shadow-sm border border-zinc-100">
              <ShieldCheck className="h-6 w-6 text-blue-600" />
            </div>
            <div>
              <h3 className="font-semibold text-lg mb-1">Expertise Technique</h3>
              <p className="text-sm text-gray-600">Conseils d'ingénieurs certifiés avant et après vente.</p>
            </div>
          </div>
          <div className="flex items-start gap-4 p-4">
            <div className="p-3 bg-white rounded-lg shadow-sm border border-zinc-100">
              <Truck className="h-6 w-6 text-blue-600" />
            </div>
            <div>
              <h3 className="font-semibold text-lg mb-1">Logistique Maîtrisée</h3>
              <p className="text-sm text-gray-600">Livraison rapide et sécurisée partout en Côte d'Ivoire.</p>
            </div>
          </div>
          <div className="flex items-start gap-4 p-4">
            <div className="p-3 bg-white rounded-lg shadow-sm border border-zinc-100">
              <Headphones className="h-6 w-6 text-blue-600" />
            </div>
            <div>
              <h3 className="font-semibold text-lg mb-1">Support Dédié</h3>
              <p className="text-sm text-gray-600">Service client accessible et réactif pour les pros.</p>
            </div>
          </div>
        </div>
      </section>

      {/* Solutions B2B - Quick Access */}
      <section className="py-20 px-6">
        <div className="max-w-7xl mx-auto">
          <div className="text-center mb-16">
            <h2 className="text-3xl font-bold tracking-tight mb-4 text-zinc-900 dark:text-zinc-100">Nos Solutions Entreprises</h2>
            <p className="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
              Des équipements sélectionnés pour leur fiabilité et leur performance en environnement professionnel.
            </p>
          </div>
          
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            <Card className="hover:shadow-lg transition-shadow border-zinc-200 dark:border-zinc-800">
              <CardHeader>
                <Network className="h-10 w-10 text-blue-600 mb-4" />
                <CardTitle>Infrastructures Réseaux</CardTitle>
                <CardDescription>Câblage, Switchs, Routeurs et Baies</CardDescription>
              </CardHeader>
              <CardContent>
                <ul className="space-y-2 mb-6 text-sm text-gray-600 dark:text-gray-400">
                  <li>• Câbles Ethernet certifiés</li>
                  <li>• Armoires de brassage</li>
                  <li>• Équipements actifs</li>
                </ul>
                <Button variant="outline" className="w-full" asChild>
                  <Link href="/products?category=reseau">Découvrir</Link>
                </Button>
              </CardContent>
            </Card>

            <Card className="hover:shadow-lg transition-shadow border-zinc-200 dark:border-zinc-800">
              <CardHeader>
                <Briefcase className="h-10 w-10 text-blue-600 mb-4" />
                <CardTitle>Postes de Travail</CardTitle>
                <CardDescription>PC Portables, Fixes et Écrans Pro</CardDescription>
              </CardHeader>
              <CardContent>
                <ul className="space-y-2 mb-6 text-sm text-gray-600 dark:text-gray-400">
                  <li>• Ordinateurs Dell / HP</li>
                  <li>• Écrans haute résolution</li>
                  <li>• Accessoires ergonomiques</li>
                </ul>
                <Button variant="outline" className="w-full" asChild>
                  <Link href="/products?category=ordinateurs">Découvrir</Link>
                </Button>
              </CardContent>
            </Card>

            <Card className="hover:shadow-lg transition-shadow border-zinc-200 dark:border-zinc-800">
              <CardHeader>
                <Cpu className="h-10 w-10 text-blue-600 mb-4" />
                <CardTitle>Maintenance & Outils</CardTitle>
                <CardDescription>Kits, Nettoyage et Pièces détachées</CardDescription>
              </CardHeader>
              <CardContent>
                <ul className="space-y-2 mb-6 text-sm text-gray-600 dark:text-gray-400">
                  <li>• Outillage de précision</li>
                  <li>• Souffleurs et maintenance</li>
                  <li>• Composants de rechange</li>
                </ul>
                <Button variant="outline" className="w-full" asChild>
                  <Link href="/products?category=outillage">Découvrir</Link>
                </Button>
              </CardContent>
            </Card>
          </div>
        </div>
      </section>

      {/* CTA Final */}
      <section className="bg-zinc-900 text-white py-20 px-6">
        <div className="max-w-4xl mx-auto text-center space-y-8">
          <h2 className="text-3xl md:text-4xl font-bold">Besoin d'une configuration sur mesure ?</h2>
          <p className="text-xl text-gray-300">
            Nos ingénieurs étudient votre besoin et vous proposent la solution la plus adaptée à votre budget et vos contraintes techniques.
          </p>
          <Button asChild size="lg" className="bg-blue-600 hover:bg-blue-700 text-white px-8 h-14 text-lg">
            <Link href="/quote">Contactez notre bureau d'études</Link>
          </Button>
        </div>
      </section>
    </div>
  );
}
