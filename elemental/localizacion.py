import pandas as pd
from geopy.geocoders import Nominatim
from geopy.extra.rate_limiter import RateLimiter

# Cargar archivo CSV con columnas: id, latitude, longitude
df = pd.read_csv('ordenes_con_coordenadas.csv')

# (Opcional) limitar para pruebas
# df = df.head(10)

# Inicializar geolocalizador con timeout extendido
geolocator = Nominatim(user_agent="ordenes_localizacion", timeout=10)
reverse = RateLimiter(geolocator.reverse, min_delay_seconds=1)

# Función para obtener barrio, localidad y ciudad con reintentos
def obtener_localidad(lat, lon):
    for _ in range(3):
        try:
            location = reverse((lat, lon), exactly_one=True, language="es")
            if location and location.raw and 'address' in location.raw:
                address = location.raw['address']
                return pd.Series({
                    'barrio': address.get('neighbourhood', ''),
                    'localidad': address.get('suburb', '') or address.get('city_district', ''),
                    'ciudad': address.get('city', '') or address.get('town', '')
                })
        except Exception as e:
            print(f"Error en ({lat}, {lon}): {e}")
    return pd.Series({'barrio': '', 'localidad': '', 'ciudad': ''})

# Aplicar reverse geocoding
resultados = df.apply(lambda row: obtener_localidad(row['latitude'], row['longitude']), axis=1)

# Combinar y exportar
df_resultado = pd.concat([df, resultados], axis=1)
df_resultado.to_csv('ordenes_geolocalizadas.csv', index=False)

print("✅ ¡Listo! Resultados guardados en 'ordenes_geolocalizadas.csv'")

# Top barrios más comunes
top_barrios = df_resultado['barrio'].value_counts().head(10)
print("\n🏘️ Barrios más comunes:")
print(top_barrios)
