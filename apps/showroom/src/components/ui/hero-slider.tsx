'use client';

import * as React from 'react';
import Image from 'next/image';
import Link from 'next/link';
import { ChevronLeft, ChevronRight } from 'lucide-react';
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { SliderItem } from '@/lib/api/sliders';

interface HeroSliderProps {
  slides: SliderItem[];
}

export function HeroSlider({ slides }: HeroSliderProps) {
  const [current, setCurrent] = React.useState(0);
  const [isAutoPlaying, setIsAutoPlaying] = React.useState(true);

  React.useEffect(() => {
    if (!isAutoPlaying || slides.length <= 1) return;

    const timer = setInterval(() => {
      setCurrent((prev) => (prev + 1) % slides.length);
    }, 5000);

    return () => clearInterval(timer);
  }, [isAutoPlaying, slides.length]);

  const next = () => setCurrent((prev) => (prev + 1) % slides.length);
  const prev = () => setCurrent((prev) => (prev - 1 + slides.length) % slides.length);

  if (!slides.length) return null;

  return (
    <div 
      className="relative w-full overflow-hidden bg-gray-100 rounded-lg group"
      onMouseEnter={() => setIsAutoPlaying(false)}
      onMouseLeave={() => setIsAutoPlaying(true)}
    >
      {/* Aspect Ratio Container */}
      <div className="relative aspect-[21/9] w-full min-h-[300px] md:min-h-[400px]">
        {slides.map((slide, index) => (
          <div
            key={slide.id}
            className={cn(
              "absolute inset-0 w-full h-full transition-opacity duration-500 ease-in-out",
              index === current ? "opacity-100 z-10" : "opacity-0 z-0"
            )}
          >
            <div className="relative w-full h-full">
              {/* Image handling for responsive */}
              <picture>
                <source media="(min-width: 1024px)" srcSet={slide.image} />
                <source media="(min-width: 768px)" srcSet={slide.tablet_image || slide.image} />
                <img
                  src={slide.mobile_image || slide.tablet_image || slide.image}
                  alt={slide.title}
                  className="w-full h-full object-cover"
                />
              </picture>
              
              {/* Text Overlay (Optional based on design) */}
              {(slide.title || slide.description) && (
                <div className="absolute inset-0 bg-gradient-to-r from-black/40 to-transparent flex items-center">
                  <div className="container px-4 md:px-10">
                    <div className="max-w-xl text-white space-y-4">
                      {slide.title && (
                        <h2 className="text-3xl md:text-5xl font-bold leading-tight">
                          {slide.title}
                        </h2>
                      )}
                      {slide.description && (
                        <p className="text-lg md:text-xl text-white/90">
                          {slide.description}
                        </p>
                      )}
                      {slide.link && (
                        <Button asChild size="lg" className="bg-primary hover:bg-primary/90 text-white border-none mt-4">
                          <Link href={slide.link}>
                            Découvrir
                          </Link>
                        </Button>
                      )}
                    </div>
                  </div>
                </div>
              )}
            </div>
          </div>
        ))}
      </div>

      {/* Navigation Arrows */}
      {slides.length > 1 && (
        <>
          <button
            onClick={prev}
            className="absolute left-4 top-1/2 -translate-y-1/2 z-20 p-2 rounded-full bg-white/30 backdrop-blur-sm hover:bg-white/50 text-white transition-all opacity-0 group-hover:opacity-100"
            aria-label="Previous slide"
          >
            <ChevronLeft className="w-6 h-6" />
          </button>
          <button
            onClick={next}
            className="absolute right-4 top-1/2 -translate-y-1/2 z-20 p-2 rounded-full bg-white/30 backdrop-blur-sm hover:bg-white/50 text-white transition-all opacity-0 group-hover:opacity-100"
            aria-label="Next slide"
          >
            <ChevronRight className="w-6 h-6" />
          </button>

          {/* Indicators */}
          <div className="absolute bottom-4 left-1/2 -translate-x-1/2 z-20 flex gap-2">
            {slides.map((_, index) => (
              <button
                key={index}
                onClick={() => setCurrent(index)}
                className={cn(
                  "w-2.5 h-2.5 rounded-full transition-all",
                  index === current ? "bg-white w-6" : "bg-white/50 hover:bg-white/80"
                )}
                aria-label={`Go to slide ${index + 1}`}
              />
            ))}
          </div>
        </>
      )}
    </div>
  );
}
