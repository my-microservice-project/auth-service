# Auth Service

Bu servis, kullanıcı kimlik doğrulama işlemlerini yönetmek için tasarlanmış bir mikroservistir.

## 🚀 Başlangıç

### Gereksinimler

- Docker
- Docker Compose

### Kurulum

1. Projeyi klonlayın
```bash
git clone https://github.com/my-microservice-project/auth-service
```

2. Proje dizinine gidin
```bash
cd auth-service
```

3. .env dosyasını oluşturun
```bash
cp .env.example .env
```

4. Docker konteynerlerini başlatın
```bash
docker-compose up -d
```

## 🛠 Servisler

Proje aşağıdaki servisleri içermektedir:

1. **Webserver (Nginx)**
   - Port: .env dosyasında belirtilen WEBSERVICE_PORT
   - Alpine tabanlı hafif Nginx sunucusu

2. **PHP-FPM**
   - PHP 8.3 versiyonu
   - Özelleştirilmiş PHP yapılandırması

## 🔑 API Endpointleri

### V1 API

#### Giriş İşlemleri
- **POST** `/api/v1/login`
  - Kullanıcı girişi için kullanılır
  - İstek gövdesi:
    ```json
    {
        "email": "string",
        "password": "string"
    }
    ```
  - Başarılı yanıt:
    ```json
    {
        "status": true,
        "message": "Giriş başarılı",
        "data": {
            "token": "jwt_token"
        }
    }
    ```

#### Çıkış İşlemleri
- **POST** `/api/v1/logout`
  - Kullanıcı çıkışı için kullanılır
  - Header'da Bearer token gereklidir
  - Başarılı yanıt:
    ```json
    {
        "status": true,
        "message": "Çıkış başarılı"
    }
    ```

## 🔒 Güvenlik

- JWT (JSON Web Token) tabanlı kimlik doğrulama
- Bearer token authentication
- Rate limiting koruması

## 🛡 Hata Kodları

- `401`: Yetkisiz erişim
- `422`: Validasyon hatası
- `429`: Çok fazla istek
- `500`: Sunucu hatası

## 📝 Notlar

- Servis, mikroservis mimarisi için tasarlanmıştır
- RESTful API prensiplerini takip eder
- Tüm yanıtlar JSON formatındadır
