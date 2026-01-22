'use client';

import * as React from 'react';
import { Brand } from '@/lib/api/brands';
import Image from 'next/image';

interface BrandsRailProps {
  brands: Brand[];
}

export function BrandsRail({ brands }: BrandsRailProps) {
  if (!brands.length) return null;

  return (
    <section className="py-12 bg-white">
      <div className="container">
        <h2 className="text-2xl font-bold mb-8 text-center">Nos Partenaires</h2>
        <div className="flex flex-wrap justify-center items-center gap-8 md:gap-12 grayscale hover:grayscale-0 transition-all duration-300">
          {brands.map((brand) => (
            <div key={brand.id} className="relative h-12 w-32 transition-all hover:scale-110">
              {brand.logo ? (
                <img
                  src={brand.logo}
                  alt={brand.name}
                  className="object-contain w-full h-full"
                  loading="lazy"
                />
              ) : (
                <span className="flex items-center justify-center h-full w-full font-semibold text-gray-400">
                  {brand.name}
                </span>
              )}
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
