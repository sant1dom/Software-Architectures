FROM python:3.10
VOLUME "/tmp"
WORKDIR /app
RUN pip install --upgrade pip
RUN pip install fastapi[all]
COPY . .
CMD ["uvicorn", "main:app", "--host", "0.0.0.0", "--port", "8081"]
