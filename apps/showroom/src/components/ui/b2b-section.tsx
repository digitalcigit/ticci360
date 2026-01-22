import Link from 'next/link';
import { Button } from '@/components/ui/button';
import { Building2, FileText, Phone } from 'lucide-react';

export function B2BSection() {
  return (
    <section className="py-16 bg-slate-900 text-white overflow-hidden relative">
      {/* Background decoration */}
      <div className="absolute top-0 right-0 w-1/2 h-full bg-primary/10 -skew-x-12 translate-x-20" />
      
      <div className="container relative z-10">
        <div className="grid md:grid-cols-2 gap-12 items-center">
          <div className="space-y-6">
            <div className="inline-flex items-center px-3 py-1 rounded-full bg-primary/20 text-primary-foreground text-sm font-medium">
              <Building2 className="w-4 h-4 mr-2" />
              Espace Entreprises & Professionnels
            </div>
            <h2 className="text-3xl md:text-4xl font-bold leading-tight">
              Besoin d'équipements pour votre entreprise ?
            </h2>
            <p className="text-lg text-slate-300">
              Profitez de notre expertise B2B : devis personnalisés sous 24h, 
              tarifs dégressifs, et accompagnement technique dédié pour vos projets.
            </p>
            <div className="flex flex-wrap gap-4">
              <Button asChild size="lg" className="bg-primary hover:bg-primary/90 text-white">
                <Link href="/contact?type=quote">
                  <FileText className="w-4 h-4 mr-2" />
                  Demander un devis
                </Link>
              </Button>
              <Button asChild variant="outline" size="lg" className="text-white border-white hover:bg-white hover:text-slate-900">
                <Link href="/contact">
                  <Phone className="w-4 h-4 mr-2" />
                  Contacter un expert
                </Link>
              </Button>
            </div>
          </div>
          
          <div className="hidden md:grid grid-cols-2 gap-4">
            <div className="space-y-4 translate-y-8">
              <div className="bg-slate-800 p-6 rounded-lg border border-slate-700">
                <h4 className="font-bold text-lg mb-2 text-primary">Audit & Conseil</h4>
                <p className="text-sm text-slate-400">Analyse de vos besoins et recommandation de solutions adaptées.</p>
              </div>
              <div className="bg-slate-800 p-6 rounded-lg border border-slate-700">
                <h4 className="font-bold text-lg mb-2 text-primary">Installation</h4>
                <p className="text-sm text-slate-400">Déploiement et configuration de votre parc informatique.</p>
              </div>
            </div>
            <div className="space-y-4">
              <div className="bg-slate-800 p-6 rounded-lg border border-slate-700">
                <h4 className="font-bold text-lg mb-2 text-primary">Maintenance</h4>
                <p className="text-sm text-slate-400">Support technique réactif et contrats de maintenance.</p>
              </div>
              <div className="bg-slate-800 p-6 rounded-lg border border-slate-700">
                <h4 className="font-bold text-lg mb-2 text-primary">Formation</h4>
                <p className="text-sm text-slate-400">Accompagnement de vos équipes sur les nouveaux outils.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
